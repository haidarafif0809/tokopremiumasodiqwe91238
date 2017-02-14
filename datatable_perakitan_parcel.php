<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
include 'sanitasi.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
  0 =>'id', 
  1 => 'kode_parcel',
  2 => 'nama_parcel',
  3 => 'harga_parcel',
  4 => 'harga_parcel_2',
  5 => 'harga_parcel_3',
  6 => 'harga_parcel_4',
  7 => 'harga_parcel_5',
  8 => 'harga_parcel_6',
  9 => 'harga_parcel_7',
  10 => 'user_input',
  11 => 'user_edit'

);

// getting total number records without any search


$sql = "SELECT id, kode_parcel, nama_parcel, harga_parcel, harga_parcel_2, harga_parcel_3, harga_parcel_4, harga_parcel_5, harga_parcel_6, harga_parcel_7, user_input, user_edit ";
$sql.=" FROM perakitan_parcel";
$query=mysqli_query($conn, $sql) or die("Salahnya Disini 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT id, kode_parcel, nama_parcel, harga_parcel, harga_parcel_2, harga_parcel_3, harga_parcel_4, harga_parcel_5, harga_parcel_6, harga_parcel_7, user_input, user_edit ";
$sql.=" FROM perakitan_parcel WHERE 1=1";


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( kode_parcel LIKE '".$requestData['search']['value']."%' ";    
  $sql.=" OR nama_parcel LIKE '".$requestData['search']['value']."%'";  
  $sql.=" OR user_input LIKE '".$requestData['search']['value']."%'";    
  $sql.=" OR user_edit LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("Salahnya Disini 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */

$query=mysqli_query($conn, $sql) or die("Salahnya Disini 3");
$data = array();

while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array();

  $nestedData[] = $row["kode_parcel"];
  $nestedData[] = $row["nama_parcel"];
  $nestedData[] = rp($row["harga_parcel"]); 
  $nestedData[] = rp($row["harga_parcel_2"]); 
  $nestedData[] = rp($row["harga_parcel_3"]); 
  $nestedData[] = rp($row["harga_parcel_4"]); 
  $nestedData[] = rp($row["harga_parcel_5"]); 
  $nestedData[] = rp($row["harga_parcel_6"]); 
  $nestedData[] = rp($row["harga_parcel_7"]); 
  $nestedData[] = $row["user_input"];
  $nestedData[] = $row["user_edit"];

  $nestedData[] ="<a href='detail_perakitan_parcel.php?id=".$row['id']."&kode_parcel=".$row['kode_parcel']."' class='btn btn-detail-parcel btn-warning'> <i class='fa fa-cart-plus'> </i></a>";

  $nestedData[] = "<button class='btn btn-edit-parcel btn-success' data-kode='". $row['kode_parcel'] ."' data-nama='". $row['nama_parcel'] ."' data-harga-1='". $row['harga_parcel'] ."' data-harga-2='". $row['harga_parcel_2'] ."' data-harga-3='". $row['harga_parcel_3'] ."' data-harga-4='". $row['harga_parcel_4'] ."' data-harga-5='". $row['harga_parcel_5'] ."' data-harga-6='". $row['harga_parcel_6'] ."' data-harga-7='". $row['harga_parcel_7'] ."' data-id='". $row['id'] ."' > Edit </button>";

  $nestedData[] = "<button class='btn btn-hapus-parcel btn-danger' data-id='". $row['id']."' data-nama='". $row['nama_parcel']."' > Hapus </button>";
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
