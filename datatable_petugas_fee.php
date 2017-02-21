<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'username', 
	1 => 'nama',
	2 => 'alamat',
	3 => 'jabatan',
	4 => 'otoritas',
  	5 => 'status',
	6 => 'id'
);

// getting total number records without any search
$sql = "SELECT u.username,u.nama,u.alamat,u.otoritas,u.status,u.id,j.nama AS jabtan  ";
$sql.=" FROM user u INNER JOIN jabatan j ON u.jabatan = j.id ";
$query=mysqli_query($conn, $sql) or die("datatable_petugas_fee.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT u.username,u.nama,u.alamat,u.otoritas,u.status,u.id,j.nama AS jabtan ";
$sql.=" FROM user u INNER JOIN jabatan j ON u.jabatan = j.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( u.username LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR u.nama  LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatablee_petugas_fee.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	  $nestedData[] = $row['username'];
    $nestedData[] = $row['nama'];
    $nestedData[] = $row['alamat'];
    $nestedData[] = $row['jabtan'];
    $nestedData[] = $row['otoritas'];
    $nestedData[] = $row['status'];
	  $nestedData[] = $row['id'];
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

