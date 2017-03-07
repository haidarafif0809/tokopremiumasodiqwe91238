<?php
include 'db.php';
include 'sanitasi.php';

// hitung bulan sebelumnya
$bulan = date('m') - 1;
 if ($bulan == 0)
 {
 	echo $bulan = 12;
 }

$bulan_sekarang = date('m');



// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	
	0 => 'kode_pelanggan',
	1 => 'nama_pelanggan',
	2 => 'no_telp',
	3 => 'jumlah'

);

// getting total number records without any search
$tes = $db->query("SELECT kode_pelanggan FROM penjualan WHERE MONTH(tanggal) = '$bulan_sekarang'");
 while($out = mysqli_fetch_array($tes))
 {
  $kode_a = $out['kode_pelanggan'];

$sql = "SELECT p.kode_pelanggan,SUM(p.total) AS jumlah,pl.nama_pelanggan,pl.no_telp";
$sql.=" FROM penjualan p INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE MONTH(p.tanggal) = '$bulan' AND p.kode_pelanggan != '$kode_a' GROUP BY p.kode_pelanggan";

$query=mysqli_query($conn, $sql) or die("1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT p.kode_pelanggan,SUM(p.total) AS jumlah,pl.nama_pelanggan,pl.no_telp";
$sql.=" FROM penjualan p INNER JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE MONTH(p.tanggal) = '$bulan' AND p.kode_pelanggan != '$kode_a'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( p.kode_pelanggan LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ) ";
} 
 $sql.=" GROUP BY p.kode_pelanggan";

 $query=mysqli_query($conn, $sql) or die("2: get employees");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


 $sql.=" ORDER BY p.kode_pelanggan ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

	$nestedData=array(); 
	
	$nestedData[] = $row["kode_pelanggan"];
	$nestedData[] = $row["nama_pelanggan"];
	$nestedData[] = $row["no_telp"];
	$nestedData[] = rp($row["jumlah"]);	 

	$data[] = $nestedData;

	}

}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>