<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';




// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
	0 =>'nama_barang', 
	1 => 'pesan_alert',
	2 => 'status',
	3 => 'Hapus',
	4 => 'edit',
  5 => 'id'
);


// getting total number records without any search
$sql = "SELECT pa.status,pa.id_promo_alert,b.nama_barang,pa.pesan_alert,pa.id_produk  ";
$sql.=" FROM promo_alert pa INNER JOIN barang b ON pa.id_produk = b.id ";
$query=mysqli_query($conn, $sql) or die("1.php: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT pa.status,pa.id_promo_alert,b.nama_barang,pa.pesan_alert,pa.id_produk  ";
$sql.=" FROM promo_alert pa INNER JOIN barang b ON pa.id_produk = b.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( b.nama_barang LIKE '".$requestData['search']['value']."%' ";    
	$sql.=" OR pa.pesan_alert LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR pa.status LIKE '".$requestData['search']['value']."%' )";
}
$query=mysqli_query($conn, $sql) or die("2.php: get employees");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql.=" ORDER BY pa.id_promo_alert ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
$query=mysqli_query($conn, $sql) or die("3.php: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array(); 

     
      
      $nestedData[] = $row['nama_barang'];
       $nestedData[] =  "<button class='btn btn-success detaili  btn-sm' data-id='".$row['id_promo_alert']."'><span class='fa fa-list'></span> Lihat Pesan </button>";
      if ($row['status'] == "1")
      {
      $nestedData[] =  "Aktif";
      }
      else
      {
      $nestedData[] = "Tidak Aktif";
      }
    $nestedData[] =  "<button data-id='". $row['id_promo_alert'] ."' class='btn btn-danger btn-hapus  btn-sm'> <span class='fa fa-trash'></span> Hapus </button>";
     $nestedData[] =  "<a href='edit_promo_alert.php?id=". $row['id_promo_alert']."&id_produk=". $row['id_produk']."' class='btn btn-warning btn-sm'><span class='fa fa-edit'></span> Edit </a>";

     $nestedData[] = $row['id_promo_alert'];

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



    

