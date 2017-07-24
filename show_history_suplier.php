<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$suplier = stringdoang($_POST['suplier']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$query_saldo_hutang_awal = $db->query("SELECT SUM(nilai_kredit) AS sum_nilai
      FROM pembelian WHERE suplier = '$suplier' AND tanggal < '$dari_tanggal'");
$data_hutang_awal_pembelian = mysqli_fetch_array($query_saldo_hutang_awal);
$nilai_kredit = $data_hutang_awal_pembelian['sum_nilai'];

$query_jumlah_bayar = $db->query("SELECT SUM(jumlah_bayar) AS sum_nilai
      FROM detail_pembayaran_hutang WHERE suplier = '$suplier' AND tanggal < '$dari_tanggal'");
$data_jumlah_bayar = mysqli_fetch_array($query_jumlah_bayar);
$jumlah_bayar = $data_jumlah_bayar['sum_nilai'];


$query_kredit_pembelian_lama = $db->query("SELECT SUM(rph.kredit_pembelian_lama) AS saldo_hutang
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal < '$dari_tanggal' ");
$data_kredit_pembelian_lama = mysqli_fetch_array($query_kredit_pembelian_lama);
$kredit_pembelian_lama = $data_kredit_pembelian_lama['saldo_hutang'];


$saldo_awal_hutang = $nilai_kredit - ($jumlah_bayar + $kredit_pembelian_lama);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


if ($requestData['start'] > 0) 
{	

		// getting total number records without any search
		$sql = $db->query("SELECT no_faktur, tanggal,jam,total,jenis,no_faktur_terkait,pembayaran,saldo_hutang
		FROM (SELECT no_faktur AS no_faktur, tanggal AS tanggal,jam AS jam,total,CONCAT('Pembelian',' (',status_beli_awal,')') AS jenis,'' AS no_faktur_terkait,tunai AS pembayaran,nilai_kredit AS saldo_hutang
      FROM pembelian WHERE suplier = '$suplier' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'
      UNION SELECT rb.no_faktur_retur AS no_faktur,  rb.tanggal,rb.jam AS jam,rb.total,'Retur Pembelian' AS jenis ,'' AS no_faktur_terkait,rb.total_bayar AS pembayaran,rph.kredit_pembelian_lama AS saldo_hutang
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal >= '$dari_tanggal' AND rb.tanggal <= '$sampai_tanggal' UNION SELECT dph.no_faktur_pembayaran AS no_faktur,  dph.tanggal,ph.jam AS jam, dph.jumlah_bayar + dph.potongan AS total ,'Pembayaran Hutang' AS jenis,dph.no_faktur_pembelian AS no_faktur_terkait,dph.jumlah_bayar + dph.potongan AS pembayaran,dph.jumlah_bayar + dph.potongan AS saldo_hutang
      FROM detail_pembayaran_hutang dph LEFT JOIN pembayaran_hutang ph ON dph.no_faktur_pembayaran = ph.no_faktur_pembayaran WHERE dph.suplier = '$suplier' AND dph.tanggal >= '$dari_tanggal' AND dph.tanggal <= '$sampai_tanggal' ) AS p ORDER BY CONCAT(tanggal,'',jam) ASC  LIMIT ".$requestData['start']."  ");
		while($row = mysqli_fetch_array($sql))
		{
			if ($row["jenis"] == 'Pembelian (Kredit)' OR $row["jenis"] == 'Pembelian (Tunai)'){

  			$saldo_awal_hutang = $saldo_awal_hutang + $row['saldo_hutang'];

			}

			else if ($row["jenis"] == 'Retur Pembelian' OR $row["jenis"] == 'Pembayaran Hutang'){

			 $saldo_awal_hutang = $saldo_awal_hutang - $row['saldo_hutang'];

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
$sql = "SELECT no_faktur, tanggal,jam,total,jenis,no_faktur_terkait,pembayaran,saldo_hutang
		FROM (SELECT no_faktur AS no_faktur, tanggal AS tanggal,jam AS jam,total,CONCAT('Pembelian',' (',status_beli_awal,')') AS jenis,'' AS no_faktur_terkait,tunai AS pembayaran,nilai_kredit AS saldo_hutang
      FROM pembelian WHERE suplier = '$suplier' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'
      UNION SELECT rb.no_faktur_retur AS no_faktur,  rb.tanggal,rb.jam AS jam,rb.total,'Retur Pembelian' AS jenis ,'' AS no_faktur_terkait,rb.total_bayar AS pembayaran,rph.kredit_pembelian_lama AS saldo_hutang
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal >= '$dari_tanggal' AND rb.tanggal <= '$sampai_tanggal' UNION SELECT dph.no_faktur_pembayaran AS no_faktur,  dph.tanggal,ph.jam AS jam, dph.jumlah_bayar + dph.potongan AS total ,'Pembayaran Hutang' AS jenis,dph.no_faktur_pembelian AS no_faktur_terkait,dph.jumlah_bayar + dph.potongan AS pembayaran,dph.jumlah_bayar + dph.potongan AS saldo_hutang
      FROM detail_pembayaran_hutang dph LEFT JOIN pembayaran_hutang ph ON dph.no_faktur_pembayaran = ph.no_faktur_pembayaran WHERE dph.suplier = '$suplier' AND dph.tanggal >= '$dari_tanggal' AND dph.tanggal <= '$sampai_tanggal' ) AS p ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT no_faktur, tanggal,jam,total,jenis,no_faktur_terkait,pembayaran,saldo_hutang
		FROM (SELECT no_faktur AS no_faktur, tanggal AS tanggal,jam AS jam,total,CONCAT('Pembelian',' (',status_beli_awal,')') AS jenis,'' AS no_faktur_terkait,tunai AS pembayaran,nilai_kredit AS saldo_hutang
      FROM pembelian WHERE suplier = '$suplier' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'
      UNION SELECT rb.no_faktur_retur AS no_faktur,  rb.tanggal,rb.jam AS jam,rb.total,'Retur Pembelian' AS jenis ,'' AS no_faktur_terkait,rb.total_bayar AS pembayaran,rph.kredit_pembelian_lama AS saldo_hutang
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal >= '$dari_tanggal' AND rb.tanggal <= '$sampai_tanggal' UNION SELECT dph.no_faktur_pembayaran AS no_faktur,  dph.tanggal,ph.jam AS jam, dph.jumlah_bayar + dph.potongan AS total ,'Pembayaran Hutang' AS jenis,dph.no_faktur_pembelian AS no_faktur_terkait,dph.jumlah_bayar + dph.potongan AS pembayaran,dph.jumlah_bayar + dph.potongan AS saldo_hutang
      FROM detail_pembayaran_hutang dph LEFT JOIN pembayaran_hutang ph ON dph.no_faktur_pembayaran = ph.no_faktur_pembayaran WHERE dph.suplier = '$suplier' AND dph.tanggal >= '$dari_tanggal' AND dph.tanggal <= '$sampai_tanggal' ) AS p ";

if( !empty($requestData['search']['value']) ) { 
  // if there is a search parameter, $requestData['search']['value'] contains search parameter

	$sql.=" AND (no_faktur LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR jenis LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%')   ";
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
 $sql.="ORDER BY CONCAT(tanggal,'',jam) ASC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";
 /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	

$query= mysqli_query($conn, $sql) or die("eror 3");



$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p style='color:red;width:140px;'>Saldo Awal</p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p style='color:red;' align='right' >".rp($saldo_awal_hutang)."</p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";

		$data[] = $nestedData;	


while($row = mysqli_fetch_array($query))
	{

$nestedData=array();

//LOGIKA UNTUK MENAMPILKAN JENIS TRANSAKSI DARI MASING" TRANSAKSI (JUMLAH PRODUK BERTAMBAH)

			
		$nestedData[] = "<p style='width:100px;' >".tgl($row["tanggal"])."</p>";
		if($row["jenis"] == 'Retur Pembelian' AND $row["total"] == 0 ){
		$nestedData[] = "<p style='width:250px;' >Retur Pembelian (Potong Hutang)";
		}
		else{
		$nestedData[] = $row["jenis"];
		}
		$nestedData[] = $row["no_faktur"];
		$nestedData[] =	$row["no_faktur_terkait"];
		$nestedData[] = "<p align='right'>".rp($row["total"])."</p>";

		$nestedData[] = "<p align='right'>".rp($row["pembayaran"])."</p>";
		
		

		if ($row["jenis"] == 'Pembelian (Kredit)' OR $row["jenis"] == 'Pembelian (Tunai)'){
  			$saldo_awal_hutang = $saldo_awal_hutang + $row['saldo_hutang'];

  			$nestedData[] = "<p align='right'> ".rp($saldo_awal_hutang)."</p>";

		}

		else if ($row["jenis"] == 'Retur Pembelian' OR $row["jenis"] == 'Pembayaran Hutang'){
			 $saldo_awal_hutang = $saldo_awal_hutang - $row['saldo_hutang'];

			$nestedData[] = "<p align='right'> ".rp($saldo_awal_hutang)."</p>";

		}

		
		if ($row["jenis"] == 'Pembelian (Kredit)' OR $row["jenis"] == 'Pembelian (Tunai)') {
			# code...
		$nestedData[] = "<button class='btn-floating detail_pembelian'  no_faktur='". $row['no_faktur'] ."'> <i class='fa fa-list'></i></button>";


			$query_pembelian = $db->query("SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,s.nama,g.nama_gudang, g.kode_gudang FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.no_faktur = '$row[no_faktur]' ");
			$data_pembelian = mysqli_fetch_array($query_pembelian);


			$pilih_akses_pembelian_edit = $db->query("SELECT pembelian_hapus,pembelian_edit FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]'");
			$oto_pembelian_edit = mysqli_fetch_array($pilih_akses_pembelian_edit);


			    if ($oto_pembelian_edit['pembelian_edit'] > 0){
							$nestedData[] = "<a href='proses_edit_pembelian.php?no_faktur=". $data_pembelian['no_faktur']."&suplier=". $data_pembelian['suplier']."&nama_gudang=".$data_pembelian['nama_gudang']."&kode_gudang=".$data_pembelian['kode_gudang']."&nama_suplier=".$data_pembelian['nama']."' class='btn-floating'> <i class='fa fa-edit'></i>  </a>"; 
				}
				else{
					$nestedData[] = "";
				}


			    if ($oto_pembelian_edit['pembelian_hapus'] > 0){

			 $retur = $db->query ("SELECT no_faktur_pembelian FROM detail_retur_pembelian WHERE no_faktur_pembelian = '$data_pembelian[no_faktur]'");
			 $row_retur = mysqli_num_rows($retur);

			 $hpp_masuk_penjualan = $db->query ("SELECT no_faktur FROM hpp_masuk WHERE no_faktur = '$data_pembelian[no_faktur]' AND sisa != jumlah_kuantitas");
			 $row_masuk = mysqli_num_rows($hpp_masuk_penjualan);

			 $hutang = $db->query ("SELECT no_faktur_pembelian FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$data_pembelian[no_faktur]'");
			 $row_hutang = mysqli_num_rows($hutang);
					
					if ($row_retur > 0 || $row_masuk > 0 || $row_hutang > 0) {

						$nestedData[] = "<button class='btn-floating btn-alert' data-id='".$data_pembelian['id']."' data-faktur='".$data_pembelian['no_faktur']."'><i class='fa fa-trash'></i></button>"; 

					}
					else{

						$nestedData[] = "<button class='btn-floating btn-hapus' data-id='".$data_pembelian['id']."' data-suplier='".$data_pembelian['nama']."' data-faktur='".$data_pembelian['no_faktur']."'><i class='fa fa-trash'></i></button>"; 

					} 
						
				}
				else{
					$nestedData[] = "";
				}


		}
		else if($row["jenis"] == 'Retur Pembelian'){
			$nestedData[] = "<button class='btn-floating detail'  no_faktur_retur='". $row['no_faktur'] ."' ><i class='fa fa-list'></i></button>";
			// edit & hapus retur pembelian

			$query_retur_pembelian = $db->query(" SELECT p.jenis_retur,p.id,p.no_faktur_retur,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.potongan,p.tax,p.tunai,p.sisa,p.cara_bayar,p.total_bayar,p.potongan_hutang,s.nama FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE p.total_bayar IS NOT NULL AND p.no_faktur_retur = '$row[no_faktur]' ");
			$data_retur_pembelian = mysqli_fetch_array($query_retur_pembelian);

			$pilih_akses_retur_pembelian = $db->query("SELECT retur_pembelian_edit,retur_pembelian_hapus FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]'");
			$retur_pembelian = mysqli_fetch_array($pilih_akses_retur_pembelian);

			if ($retur_pembelian['retur_pembelian_edit'] > 0) {

				if ($data_retur_pembelian['jenis_retur'] == "1"){
				$nestedData[] = "<a href='proses_edit_retur_pembelian.php?no_faktur_retur=". $data_retur_pembelian['no_faktur_retur']."&nama=". $data_retur_pembelian['nama']."&cara_bayar=".$data_retur_pembelian['cara_bayar']."&suplier=".$data_retur_pembelian['nama_suplier']."' class='btn-floating'>  <i class='fa fa-edit'></i> </a> </td> ";
				}
				else{
					$nestedData[] = "<a href='proses_edit_retur_pembelian_faktur.php?no_faktur_retur=". $data_retur_pembelian['no_faktur_retur']."&nama=". $data_retur_pembelian['nama']."&cara_bayar=".$data_retur_pembelian['cara_bayar']."&suplier=".$data_retur_pembelian['nama_suplier']."' class='btn-floating'>  <i class='fa fa-edit'></i> </a>";
				}

			}
			else{
				$nestedData[] = "";
			}

			if ($retur_pembelian['retur_pembelian_hapus'] > 0) {
				if ($data_retur_pembelian['jenis_retur'] == "1"){
					$nestedData[] = "<button class='btn-floating btn-hapus-r1' data-id='". $data_retur_pembelian['id'] ."' data-faktur='". $data_retur_pembelian['no_faktur_retur'] ."' data-suplier='". $data_retur_pembelian['nama'] ."'> <i class='fa fa-trash'></i> </button> ";
				}
				else{
					$nestedData[] = "<button class='btn-floating btn-hapus-r2' data-id='". $data_retur_pembelian['id'] ."' data-faktur='". $data_retur_pembelian['no_faktur_retur'] ."' data-suplier='". $data_retur_pembelian['nama'] ."'> <i class='fa fa-trash'></i> </button>";
					}
			}
			else{
				$nestedData[] = "";
			} 
			// edit & hapus retur pembelian


		}

		else if($row["jenis"] == 'Pembayaran Hutang'){

			$nestedData[] = "<button class='btn-floating detail_pembayaran_hutang'  no_faktur_pembayaran='". $row['no_faktur'] ."'><i class='fa fa-list'></i></button>";

			$query_pembayaran_hutang = $db->query("SELECT p.id,p.no_faktur_pembayaran,p.keterangan,p.total,p.nama_suplier,p.tanggal,p.tanggal_edit,p.jam,p.user_buat,p.user_edit,p.dari_kas,s.nama,da.nama_daftar_akun FROM pembayaran_hutang p INNER JOIN suplier s ON p.nama_suplier = s.id INNER JOIN daftar_akun da ON p.dari_kas = da.kode_daftar_akun WHERE p.no_faktur_pembayaran = '$row[no_faktur]' ");
			$data_pembayaran_hutang = mysqli_fetch_array($query_pembayaran_hutang);

			$pilih_akses_pembayaran_hutang = $db->query("SELECT pembayaran_hutang_edit,pembayaran_hutang_hapus FROM otoritas_pembayaran WHERE id_otoritas = '$_SESSION[otoritas_id]'");
		$pembayaran_hutang = mysqli_fetch_array($pilih_akses_pembayaran_hutang);


				if ($pembayaran_hutang['pembayaran_hutang_edit'] > 0) {

					$nestedData[] = "<a href='proses_edit_pembayaran_hutang.php?no_faktur_pembayaran=". $data_pembayaran_hutang['no_faktur_pembayaran']."&nama=". $data_pembayaran_hutang['nama']."&cara_bayar=". $data_pembayaran_hutang['dari_kas']."' class='btn-floating'> <i class='fa fa-edit'></i>  </a>";

				}
				else{
					$nestedData[] = "";
				}



				if ($pembayaran_hutang['pembayaran_hutang_hapus'] > 0) {

					$nestedData[] = "<button class='btn-floating btn-hapus-ph' data-id='". $data_pembayaran_hutang['id'] ."' data-suplier='". $data_pembayaran_hutang['nama'] ."' data-no_faktur_pembayaran='". $data_pembayaran_hutang['no_faktur_pembayaran'] ."'> <i class='fa fa-trash'></i>  </button>";
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


