<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$jumlah_data = 0;

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name


      0 => 'nama',
      1 => 'no_faktur',
      2 => 'kode_produk',
      3 => 'nama_produk',
      4 => 'jumlah_fee',
      5 => 'tanggal',
      6 => 'jam'



);

// getting total number records without any search



$sql =" SELECT u.nama,lp.nama_petugas,lp.no_faktur,lp.kode_produk,lp.nama_produk,lp.jumlah_fee,lp.tanggal,lp.jam ";
$sql.=" FROM laporan_fee_produk lp LEFT JOIN user u ON lp.nama_petugas = u.id ";

$query = mysqli_query($conn, $sql) or die("eror 1");
if( !empty($requestData['search']['value']) ) {   

    $sql.=" WHERE (u.nama LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR lp.no_faktur LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR lp.nama_produk LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR lp.kode_produk LIKE '".$requestData['search']['value']."%' )";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY lp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $jumlah_data = $jumlah_data + 1;

      $nestedData[] = $row['nama'];
      $nestedData[] = $row['no_faktur'];
      $nestedData[] = $row['kode_produk'];
      $nestedData[] = $row['nama_produk'];
      $nestedData[] = rp($row['jumlah_fee']);
      $nestedData[] = tanggal($row['tanggal']);
      $nestedData[] = $row['jam'];
      $data[] = $nestedData;
}

$totalData = $jumlah_data;
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data
            // total data array
            );

echo json_encode($json_data);  // send data as json format

 ?>