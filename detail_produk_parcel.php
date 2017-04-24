<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_faktur = stringdoang($_POST['no_faktur']);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'id', 
    1=>'kode_parcel',
    2=>'id_produk',
    3=>'jumlah_produk'

);

// getting total number records without any search
$sql =" SELECT tp.id, tp.kode_parcel, tp.id_produk, tp.jumlah_produk, b.kode_barang, b.nama_barang, b.satuan, s.nama";
$sql.=" FROM detail_perakitan_parcel tp INNER JOIN barang b ON tp.id_produk = b.id INNER JOIN satuan s ON b.satuan = s.id";
$sql.=" WHERE tp.no_faktur = '$no_faktur'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.id, tp.kode_parcel, tp.id_produk, tp.jumlah_produk, b.kode_barang, b.nama_barang, b.satuan, s.nama";
$sql.=" FROM detail_perakitan_parcel tp INNER JOIN barang b ON tp.id_produk = b.id INNER JOIN satuan s ON b.satuan = s.id";
$sql.=" WHERE tp.no_faktur = '$no_faktur'";

    $sql.=" AND (b.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array();

      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];
      $nestedData[] = $row["jumlah_produk"];
      $nestedData[] = $row["nama"];

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