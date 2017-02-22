<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

$nomor = stringdoang($_POST['nomor']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'kode_barang', 
	1 => 'nama_barang',
	2 => 'kategori',
	3 => 'hpp',
	4 => 'harga_lama',
	5 => 'harga_baru',
	6 => 'pembulatan'

);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM tbs_perubahan_harga_masal WHERE nomor = '$nomor'";

$query=mysqli_query($conn, $sql) or die("show_data_perubahan_harga_masal.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT * ";
$sql.=" FROM tbs_perubahan_harga_masal WHERE nomor = '$nomor'";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( kode_barang LIKE '".$requestData['search']['value']."%' "; 
	$sql.=" OR nama_barang LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("show_data_perubahan_harga_masal.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("show_data_perubahan_harga_masal.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["kode_barang"];
	$nestedData[] = $row["nama_barang"];
	$nestedData[] = $row["kategori"];
	$nestedData[] = rp($row["hpp"]);
	$nestedData[] = rp($row["harga_lama"]);	  
	$nestedData[] = rp($row["harga_baru"]);	
	$nestedData[] = rp($row["pembulatan"]);	         
	$data[] = $nestedData;

}


$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
