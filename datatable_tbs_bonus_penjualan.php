<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = session_id();

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_produk', 
    1=>'nama_produk',
    2=>'id' 

);

// getting total number records without any search
$sql =" SELECT * ";
$sql.=" FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND kode_pelanggan IS NULL ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT * ";
$sql.=" FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND kode_pelanggan IS NULL AND 1=1 ";

    $sql.=" AND (kode_produk LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR nama_produk LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["kode_produk"];
      $nestedData[] = $row["nama_produk"] ." | ". $row["keterangan"];
      $nestedData[] = rp($row["qty_bonus"]);
      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbsbonus' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."' data-kode-produk='". $row['kode_produk'] ."' data-produk='". $row['nama_produk'] ."' data-qty='". $row['qty_bonus'] ."'>Hapus</button>";
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