<?php
include 'db.php';
include 'sanitasi.php';

// hitung bulan sebelumnya
$bulan = date('m') - 1;
 if ($bulan == 0)
 {
  $bulan = 12;
 }

$bulan_sekarang = date('m');
$totalData = 0;
$totalFiltered = 0;
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	
	0 => 'kode_barang',
	1 => 'nama_barang',
	2 => 'satuan',
	3 => 'jumlah'

);

	
$sql = "SELECT p.kode_barang, SUM(p.jumlah_barang) AS jumlah, s.nama, p.nama_barang";
$sql.=" FROM detail_penjualan p LEFT JOIN satuan s ON p.satuan = s.id WHERE MONTH(p.tanggal) = '$bulan' ";

$query=mysqli_query($conn, $sql) or die("1: get employees");

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( p.kode_barang LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR s.nama LIKE '".$requestData['search']['value']."%'  ";
	$sql.=" OR p.nama_barang LIKE '".$requestData['search']['value']."%' )  ";
} 

 $sql.=" GROUP BY p.kode_barang";

 $query=mysqli_query($conn, $sql) or die("2: get employees");

 $sql.=" ORDER BY p.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

	
	$query_detail = $db->query("SELECT COUNT(kode_barang) AS jumlah_data FROM detail_penjualan WHERE kode_barang = '$row[kode_barang]' AND MONTH(tanggal) = '$bulan_sekarang' ");
	$data_detail = mysqli_fetch_array($query_detail);

	if ($data_detail['jumlah_data'] == 0) {
	
	$nestedData=array(); 
	$totalData = $totalData + 1;
	$totalFiltered = $totalData; 
	
	
	$nestedData[] = $row["kode_barang"];
	$nestedData[] = $row["nama_barang"];
	$nestedData[] = $row["nama"];	
	$nestedData[] = rp($row["jumlah"]);	 
	$data[] = $nestedData;
	
	}else{

	}
	

	
	}
	 	 

	if ($totalData == 0) {

		echo '{"draw":1,"recordsTotal":0,"recordsFiltered":0,"data":[]}';

	}else{

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

		echo json_encode($json_data);  // send data as json format
	}



?>