<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$pelanggan = stringdoang($_POST['pelanggan']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$query_saldo_piutang_awal = $db->query("SELECT SUM(nilai_kredit) AS sum_nilai
      FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal < '$dari_tanggal'");
$data_piutang_awal_Penjualan = mysqli_fetch_array($query_saldo_piutang_awal);
$nilai_kredit = $data_piutang_awal_Penjualan['sum_nilai'];

$query_jumlah_bayar = $db->query("SELECT SUM(jumlah_bayar) AS sum_nilai
      FROM detail_pembayaran_piutang WHERE kode_pelanggan = '$pelanggan' AND tanggal < '$dari_tanggal'");
$data_jumlah_bayar = mysqli_fetch_array($query_jumlah_bayar);
$jumlah_bayar = $data_jumlah_bayar['sum_nilai'];

$saldo_awal_piutang = $nilai_kredit - $jumlah_bayar;
$jumlah_data = 0;

$query_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE id = '$pelanggan' ");
$data_pelanggan = mysqli_fetch_array($query_pelanggan);

$pilih_akses_penjualan_edit = $db->query("SELECT retur_penjualan_hapus,retur_penjualan_edit,penjualan_hapus,penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$aksespenjualan = mysqli_fetch_array($pilih_akses_penjualan_edit);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

 
if ($requestData['start'] > 0) 
{	

		// getting total number records without any search
	$sql = $db->query("SELECT jenis,saldo_piutang FROM (SELECT CONCAT('Penjualan',' (',status_jual_awal,')') AS jenis,nilai_kredit AS saldo_piutang
      FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'
      UNION SELECT 'Retur Penjualan' AS jenis ,total AS saldo_piutang FROM retur_penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'  UNION SELECT 'Pembayaran Piutang' AS jenis,jumlah_bayar + potongan AS saldo_piutang FROM detail_pembayaran_piutang dpp LEFT JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran WHERE kode_pelanggan = '$pelanggan' AND dpp.tanggal >= '$dari_tanggal' AND dpp.tanggal <= '$sampai_tanggal' ) AS p ORDER BY CONCAT(tanggal,'',jam) LIMIT ".$requestData['start']." ");
		while($row = mysqli_fetch_array($sql))
		{
			if ($row["jenis"] == 'Penjualan (Kredit)' OR $row["jenis"] == 'Penjualan (Tunai)'){

  			$saldo_awal_piutang = $saldo_awal_piutang + $row['saldo_piutang'];

			}

			else if ($row["jenis"] == 'Retur Penjualan' OR $row["jenis"] == 'Pembayaran Piutang'){

			 $saldo_awal_piutang = $saldo_awal_piutang - $row['saldo_piutang'];

			}

		} 

}


$columns = array( 
// datatable column index  => database column name

	0 =>'no_faktur', 
	1 => 'tipe_transaksi',
	2=> 'tanggal',
	3 => 'masuk',
	4=> 'keluar',
	5=> 'saldo',
	6=> 'sa',
	6=> 'detail'

);
// data yang akan di tampilkan di table


// getting total number records without any search

$sql = "SELECT no_faktur, tanggal,jam,total,jenis,no_faktur_terkait,pembayaran,saldo_piutang FROM (SELECT no_faktur AS no_faktur, tanggal AS tanggal,jam AS jam,total,CONCAT('Penjualan',' (',status_jual_awal,')') AS jenis,'' AS no_faktur_terkait,tunai AS pembayaran,nilai_kredit AS saldo_piutang ";
$sql .= "FROM penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'  ";
$sql .= "UNION SELECT no_faktur_retur AS no_faktur,  tanggal,jam AS jam,total,'Retur Penjualan' AS jenis ,'' AS no_faktur_terkait,tunai AS pembayaran,total AS saldo_piutang ";
$sql .= "FROM retur_penjualan WHERE kode_pelanggan = '$pelanggan' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ";
$sql .= "UNION SELECT dpp.no_faktur_pembayaran AS no_faktur,  pp.tanggal,pp.jam AS jam, jumlah_bayar + potongan AS total ,'Pembayaran Piutang' AS jenis,no_faktur_penjualan AS no_faktur_terkait,jumlah_bayar + potongan AS pembayaran,jumlah_bayar + potongan AS saldo_piutang ";
$sql .= " FROM detail_pembayaran_piutang dpp LEFT JOIN pembayaran_piutang pp ON dpp.no_faktur_pembayaran = pp.no_faktur_pembayaran  WHERE kode_pelanggan = '$pelanggan' AND dpp.tanggal >= '$dari_tanggal' AND dpp.tanggal <= '$sampai_tanggal' ) AS p ";

$query = mysqli_query($conn, $sql) or die("eror 1");

if( !empty($requestData['search']['value']) ) { 
  // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" WHERE (no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jenis LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%')   ";
}
$query=mysqli_query($conn, $sql) or die("eror 2");

while($hitung_data = mysqli_fetch_array($query)) {
		
	$jumlah_data = $jumlah_data + 1;

}

$totalData = $jumlah_data;

$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
                              

$sql.="ORDER BY CONCAT(tanggal,'',jam) ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
 /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query= mysqli_query($conn, $sql) or die("eror 3");

$data = array();

$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p style='color:red;width:140px;'>Saldo Awal</p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p style='color:red;' align='right' >".rp($saldo_awal_piutang)."</p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";

	$data[] = $nestedData;	


while($row = mysqli_fetch_array($query))
	{

$nestedData=array();

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)

			
		$nestedData[] = "<p style='width:100px;' >".tgl($row["tanggal"])."</p>";
		$nestedData[] = $row["jenis"];		
		$nestedData[] = $row["no_faktur"];
		$nestedData[] =	$row["no_faktur_terkait"];
		$nestedData[] = "<p align='right'>".rp($row["total"])."</p>";
		$nestedData[] = "<p align='right'>".rp($row["pembayaran"])."</p>";	
		

		if ($row["jenis"] == 'Penjualan (Kredit)' OR $row["jenis"] == 'Penjualan (Tunai)'){
  			$saldo_awal_piutang = $saldo_awal_piutang + $row['saldo_piutang'];

  			$nestedData[] = "<p align='right'> ".rp($saldo_awal_piutang)."</p>";

		}

		else if ($row["jenis"] == 'Retur Penjualan' OR $row["jenis"] == 'Pembayaran Piutang'){
			 $saldo_awal_piutang = $saldo_awal_piutang - $row['saldo_piutang'];

			$nestedData[] = "<p align='right'> ".rp($saldo_awal_piutang)."</p>";

		}

		
		if ($row["jenis"] == 'Penjualan (Kredit)' OR $row["jenis"] == 'Penjualan (Tunai)') {
			# code...
		$nestedData[] = "<button class='btn-floating detail_penjualan'  no_faktur='". $row['no_faktur'] ."'> <i class='fa fa-list'></i></button>";


			$query_Penjualan = $db->query("SELECT p.kode_meja,p.id,p.kode_gudang, g.nama_gudang FROM penjualan p INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.no_faktur = '$row[no_faktur]' ");
			$data_Penjualan = mysqli_fetch_array($query_Penjualan);

	
				
				if ($aksespenjualan['penjualan_edit'] > 0){
				
				$nestedData[] = "<a href='proses_edit_penjualan.php?no_faktur=". $row['no_faktur']."&kode_pelanggan=". $pelanggan."&nama_gudang=".$data_Penjualan['nama_gudang']."&kode_gudang=".$data_Penjualan['kode_gudang']."' class='btn-floating'> <i class='fa fa-edit'></i> </a>";	
				
				
				}else{
					$nestedData[] = "";
				}			


			    if ($aksespenjualan['penjualan_hapus'] > 0){

						$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_retur_penjualan WHERE no_faktur_penjualan = '$row[no_faktur]'");
						$row_retur = mysqli_num_rows($pilih);

						$pilih = $db->query("SELECT no_faktur_penjualan FROM detail_pembayaran_piutang WHERE no_faktur_penjualan = '$row[no_faktur]'");
						$row_piutang = mysqli_num_rows($pilih);

						if ($row_retur > 0 || $row_piutang > 0) {

							$nestedData[] = "<button class='btn-floating btn-alert-jual' data-id='".$data_Penjualan['id']."' data-faktur='".$row['no_faktur']."'><i class='fa fa-trash'></i></button>";

						} 

						else {

							$nestedData[] = "<button class='btn-floating btn-hapus-jual' data-id='".$data_Penjualan['id']."' data-pelanggan='".$data_pelanggan['nama_pelanggan']."' data-faktur='".$row['no_faktur']."'
							 kode_meja='".$data_Penjualan['kode_meja']."'><i class='fa fa-trash'></i></button>";
						}
						
				}
				else{
					$nestedData[] = "";
				}


		}
		else if($row["jenis"] == 'Retur Penjualan'){
			$nestedData[] = "<button class='btn-floating detail_retur_penjualan'  no_faktur_retur='". $row['no_faktur'] ."' ><i class='fa fa-list'></i></button>";
			// edit & hapus retur Penjualan

			$query_retur_Penjualan = $db->query(" SELECT id FROM retur_penjualan WHERE total IS NOT NULL AND no_faktur_retur = '$row[no_faktur]' ");
			$data_retur_Penjualan = mysqli_fetch_array($query_retur_Penjualan);

			if ($aksespenjualan['retur_penjualan_edit'] > 0) {

				$nestedData[] = "<a href='proses_edit_retur_penjualan.php?no_faktur_retur=". $row['no_faktur']."' class='btn-floating'>  <i class='fa fa-edit'></i> </a>";
			}
			else{
				$nestedData[] = "";
			}

			if ($aksespenjualan['retur_penjualan_hapus'] > 0) {
				
				$pilih = $db->query("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$row[no_faktur]' AND sisa != jumlah_kuantitas");
				$row_alert = mysqli_num_rows($pilih);

				if ($row_alert > 0) {
					

					$nestedData[] = "<button class='btn-floating btn-alert-retur' data-id='". $data_retur_Penjualan['id'] ."' data-faktur='". $row['no_faktur'] ."' data-pelanggan='". $data_pelanggan['nama_pelanggan'] ."'> <i class='fa fa-trash'></i> </button>";
				} 

				else {

					$nestedData[] = "<button class='btn-floating btn-hapus-retur' data-id='". $data_retur_Penjualan['id'] ."' data-faktur='". $row['no_faktur'] ."' data-pelanggan='". $data_pelanggan['nama_pelanggan'] ."'><i class='fa fa-trash'></i></button> ";
				}

			}
			else{
				$nestedData[] = "";
			} 
			// edit & hapus retur Penjualan


		}

		else if($row["jenis"] == 'Pembayaran Piutang'){

			$nestedData[] = "<button class='btn-floating detail_pembayaran_piutang'  no_faktur_pembayaran='". $row['no_faktur'] ."'><i class='fa fa-list'></i></button>";

			$query_pembayaran_piutang = $db->query("SELECT id FROM pembayaran_piutang WHERE no_faktur_pembayaran = '$row[no_faktur]' ");
			$data_pembayaran_piutang = mysqli_fetch_array($query_pembayaran_piutang);

			$pilih_akses_pembayaran_piutang = $db->query("SELECT pembayaran_piutang_edit,pembayaran_piutang_hapus FROM otoritas_pembayaran WHERE id_otoritas = '$_SESSION[otoritas_id]'");
			$pembayaran_piutang = mysqli_fetch_array($pilih_akses_pembayaran_piutang);


				if ($pembayaran_piutang['pembayaran_piutang_edit'] > 0) {

					$nestedData[] = "<a href='proses_edit_pembayaran_piutang.php?no_faktur_pembayaran=". $row['no_faktur']."&no_faktur_penjualan=". $row['no_faktur_terkait']."' class='btn-floating'> <i class='fa fa-edit'></i> </a>";

				}
				else{
					$nestedData[] = "";
				}



				if ($pembayaran_piutang['pembayaran_piutang_hapus'] > 0) {

					$nestedData[] = "<button class='btn-floating btn-hapus-pp' data-id='". $data_pembayaran_piutang['id'] ."' data-pelanggan='". $data_pelanggan['nama_pelanggan'] ."' data-no_faktur_pembayaran='". $row['no_faktur'] ."'> <i class='fa fa-trash'></i>  </button>";
					}
				else{
					$nestedData[] = "";
				} 

		}
		$data[] = $nestedData;	



} // end while

$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format
?>


