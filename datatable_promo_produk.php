<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';
/* Database connection end */


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
	0 =>'nama_produk', 
	1 => 'id'
);

// getting total number records without any search
$sql = "SELECT * ";
$sql.=" FROM promo_produk ";
$query=mysqli_query($conn, $sql) or die("datatable_free_produk.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT * ";
$sql.=" FROM promo_produk WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( nama_produk LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("datatableee_free_produk.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["nama_produk"];
	
	//edit
	$nestedData[] = '<button class="btn btn-warning btn-edit" data-id="'.$row['id'].'">
	            <span class="glyphicon glyphicon-wrench"> </span> Edit </button>';
	    
	      //hapus
	$nestedData[] = '<button class="btn btn-danger btn-hapus" data-id="'.$row['id'].'">
	            <span class="glyphicon glyphicon-trash"> </span> Hapus </button>';
	          
	$nestedData[] = $row["id"];

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


