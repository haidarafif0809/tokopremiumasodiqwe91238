<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_parcel', 
    1=>'nama_parcel',
    2=>'harga_parcel',
    3=>'harga_parcel_2',
    4=>'harga_parcel_3',
    5=>'harga_parcel_4', 
    6=>'harga_parcel_5',
    7=>'harga_parcel_6',
    8=>'harga_parcel_7',
    9=>'jumlah_parcel',
    10=>'no_faktur',
    11=>'id'


);

// getting total number records without any search
$sql = "SELECT kode_parcel, nama_parcel, harga_parcel, harga_parcel_2, harga_parcel_3, harga_parcel_4, harga_parcel_5, harga_parcel_6, harga_parcel_7, jumlah_parcel, no_faktur, id";
$sql.=" FROM perakitan_parcel ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT kode_parcel, nama_parcel, harga_parcel, harga_parcel_2, harga_parcel_3, harga_parcel_4, harga_parcel_5, harga_parcel_6, harga_parcel_7, jumlah_parcel, no_faktur, id";
$sql.=" FROM perakitan_parcel ";
$sql.=" WHERE ";

    $sql.=" kode_parcel LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR nama_parcel LIKE '".$requestData['search']['value']."%' ";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

    // mencari jumlah Barang
             $select = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_hpp_masuk FROM hpp_masuk WHERE kode_barang = '$row[kode_parcel]'");
             $ambil_masuk = mysqli_fetch_array($select);
             
             $select_2 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_hpp_keluar FROM hpp_keluar WHERE kode_barang = '$row[kode_parcel]'");
             $ambil_keluar = mysqli_fetch_array($select_2);
             
             $stok_barang = $ambil_masuk['jumlah_hpp_masuk'] - $ambil_keluar['jumlah_hpp_keluar'];
   

    $nestedData=array(); 

    $nestedData[] = $row["kode_parcel"];
    $nestedData[] = $row["nama_parcel"];
    $nestedData[] = rp($stok_barang);
    $nestedData[] = rp($row["harga_parcel"]);
    $nestedData[] = rp($row["harga_parcel_2"]);
    $nestedData[] = rp($row["harga_parcel_3"]);
    $nestedData[] = rp($row["harga_parcel_4"]);
    $nestedData[] = rp($row["harga_parcel_5"]);
    $nestedData[] = rp($row["harga_parcel_6"]);
    $nestedData[] = rp($row["harga_parcel_7"]);
    $nestedData[] = $row["no_faktur"];
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