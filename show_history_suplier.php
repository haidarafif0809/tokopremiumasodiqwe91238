<?php 
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
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal >= '$dari_tanggal' AND rb.tanggal <= '$sampai_tanggal' UNION SELECT dph.no_faktur_pembayaran AS no_faktur,  dph.tanggal,ph.jam AS jam, dph.jumlah_bayar AS total ,'Pembayaran Hutang' AS jenis,dph.no_faktur_pembelian AS no_faktur_terkait,dph.jumlah_bayar AS pembayaran,dph.jumlah_bayar AS saldo_hutang
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
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal >= '$dari_tanggal' AND rb.tanggal <= '$sampai_tanggal' UNION SELECT dph.no_faktur_pembayaran AS no_faktur,  dph.tanggal,ph.jam AS jam, dph.jumlah_bayar AS total ,'Pembayaran Hutang' AS jenis,dph.no_faktur_pembelian AS no_faktur_terkait,dph.jumlah_bayar AS pembayaran,dph.jumlah_bayar AS saldo_hutang
      FROM detail_pembayaran_hutang dph LEFT JOIN pembayaran_hutang ph ON dph.no_faktur_pembayaran = ph.no_faktur_pembayaran WHERE dph.suplier = '$suplier' AND dph.tanggal >= '$dari_tanggal' AND dph.tanggal <= '$sampai_tanggal' ) AS p ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT no_faktur, tanggal,jam,total,jenis,no_faktur_terkait,pembayaran,saldo_hutang
		FROM (SELECT no_faktur AS no_faktur, tanggal AS tanggal,jam AS jam,total,CONCAT('Pembelian',' (',status_beli_awal,')') AS jenis,'' AS no_faktur_terkait,tunai AS pembayaran,nilai_kredit AS saldo_hutang
      FROM pembelian WHERE suplier = '$suplier' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'
      UNION SELECT rb.no_faktur_retur AS no_faktur,  rb.tanggal,rb.jam AS jam,rb.total,'Retur Pembelian' AS jenis ,'' AS no_faktur_terkait,rb.total_bayar AS pembayaran,rph.kredit_pembelian_lama AS saldo_hutang
      FROM retur_pembelian rb LEFT JOIN retur_pembayaran_hutang rph ON rb.no_faktur_retur = rph.no_faktur_retur  WHERE rb.nama_suplier = '$suplier' AND rb.tanggal >= '$dari_tanggal' AND rb.tanggal <= '$sampai_tanggal' UNION SELECT dph.no_faktur_pembayaran AS no_faktur,  dph.tanggal,ph.jam AS jam, dph.jumlah_bayar AS total ,'Pembayaran Hutang' AS jenis,dph.no_faktur_pembelian AS no_faktur_terkait,dph.jumlah_bayar AS pembayaran,dph.jumlah_bayar AS saldo_hutang
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
$nestedData[] = "<p style='color:red;width:140px;'>Saldo Hutang Awal</p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p></p>";
$nestedData[] = "<p style='color:red;' align='right' >".rp($saldo_awal_hutang)."</p>";
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
		
		if($row["saldo_hutang"] == ""){
		$nestedData[] = "<p style='color:red;width:110px;' align='right'>Tidak Ada Perubahan</p>";
		}else{


		if ($row["jenis"] == 'Pembelian (Kredit)' OR $row["jenis"] == 'Pembelian (Tunai)'){
  			$saldo_awal_hutang = $saldo_awal_hutang + $row['saldo_hutang'];

  			$nestedData[] = "<p align='right'> ".rp($saldo_awal_hutang)."</p>";

		}

		else if ($row["jenis"] == 'Retur Pembelian' OR $row["jenis"] == 'Pembayaran Hutang'){
			 $saldo_awal_hutang = $saldo_awal_hutang - $row['saldo_hutang'];

			$nestedData[] = "<p align='right'> ".rp($saldo_awal_hutang)."</p>";

		}

		}

		if ($row["jenis"] == 'Pembelian (Kredit)' OR $row["jenis"] == 'Pembelian (Tunai)') {
			# code...
		$nestedData[] = "<button class='btn btn-info detail_pembelian' style='width:200px;' no_faktur='". $row['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Pembelian </button>";
		}
		else if($row["jenis"] == 'Retur Pembelian'){
			$nestedData[] = "<button class='btn btn-warning detail' style='width:200px;' no_faktur_retur='". $row['no_faktur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Retur Pembelian </button>";

		}
		else if($row["jenis"] == 'Pembayaran Hutang'){
			$nestedData[] = "<button class=' btn btn-success detail_pembayaran_hutang' style='width:200px;' no_faktur_pembayaran='". $row['no_faktur'] ."'> Pembayaran Hutang  </button>";

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


