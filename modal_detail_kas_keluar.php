<?php
include 'db.php';
include 'sanitasi.php';

$no_faktur = $_POST['no_faktur'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    
          
    0=>'no_faktur', 
    1=>'dari_akun',
    2=>'ke_akun',
    3=>'jumlah_barang',
    4=>'tanggal',
    5=>'jam', 
    6=>'keterangan',
    7=>'petugas',
    8=>'id'

);

// getting total number records without any search

$sql = "SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun,
        km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun";
$sql.=" FROM detail_kas_keluar km LEFT JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun";
$sql.=" WHERE no_faktur = '$no_faktur'";

$query=mysqli_query($conn, $sql) or die("1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT km.id, km.no_faktur, km.keterangan, km.ke_akun, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun";
$sql.=" FROM detail_kas_keluar km LEFT JOIN daftar_akun da ON km.ke_akun = da.kode_daftar_akun";
$sql.=" WHERE no_faktur = '$no_faktur'";


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( km.no_faktur LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR km.tanggal LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR da.nama_daftar_akun LIKE '".$requestData['search']['value']."%' ) ";
} 

 $query=mysqli_query($conn, $sql) or die("2: get employees");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

 $sql.=" ORDER BY km.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

    $nestedData=array(); 
  
  $perintah1 = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM detail_kas_keluar km LEFT JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun WHERE km.dari_akun = '$row[dari_akun]'");
        $data10 = mysqli_fetch_array($perintah1);

    $nestedData[] = $row["no_faktur"];
    $nestedData[] = $data10["nama_daftar_akun"];
    $nestedData[] = $row["nama_daftar_akun"];
    $nestedData[] = rp($row["jumlah"]);
    $nestedData[] = $row["tanggal"];
    $nestedData[] = $row["jam"];
    $nestedData[] = $row["keterangan"];
    $nestedData[] = $row["user"];

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