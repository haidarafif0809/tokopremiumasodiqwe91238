<?php
include 'db.php';
include 'sanitasi.php';

/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'nomor', 
	1 => 'kategori',
	2 => 'perubahan_harga',
	3 => 'acuan_harga',
	4 => 'pola_perubahan',
	5 => 'jumlah_nilai',
	6 => 'petugas',
	7 => 'tanggal',
	8 => 'status'


);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM data_perubahan_masal";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM data_perubahan_masal WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nomor LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR petugas LIKE '".$requestData['search']['value']."%' ";   
	$sql.=" OR tanggal LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR status LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nomor"];
	$nestedData[] = $row["kategori"];
	$nestedData[] = $row["perubahan_harga"];
	$nestedData[] = $row["acuan_harga"];
	$nestedData[] = $row["pola_perubahan"];

	if($row["nilai"] == 'Persentase')
	{
		$nestedData[] = rp($row["jumlah_nilai"])." %";
	}
	else
	{
		$nestedData[] = rp($row["jumlah_nilai"]);
	}

	$nestedData[] = $row["petugas"];
	$nestedData[] = $row["tanggal"];
	$nestedData[] = $row["status"];
	
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
