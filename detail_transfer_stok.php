<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_faktur = stringdoang($_POST['no_faktur']);

$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

    0=>'no_faktur', 
    1=>'kode_barang',
    2=>'nama_barang',
    3=>'kode_barang',
    4=>'nama_barang',
    5=>'satuan',
    6=>'jumlah',
    7=>'harga',
    8=>'subtotal'
);

// getting total number records without any search
$sql = "SELECT ts.kode_barang_tujuan,ts.nama_barang_tujuan,ts.no_faktur,ts.kode_barang,ts.nama_barang,ts.jumlah,satuan.nama AS satuan ,ts.harga, ts.subtotal ";
$sql.=" FROM detail_transfer_stok ts LEFT JOIN satuan ON ts.satuan = satuan.id ";
$sql.=" WHERE ts.no_faktur = '$no_faktur'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

$sql = "SELECT ts.kode_barang_tujuan,ts.nama_barang_tujuan,ts.no_faktur,ts.kode_barang,ts.nama_barang,ts.jumlah,satuan.nama AS satuan ,ts.harga, ts.subtotal ";
$sql.=" FROM detail_transfer_stok ts LEFT JOIN satuan ON ts.satuan = satuan.id ";
$sql.=" WHERE ts.no_faktur = '$no_faktur'";

    $sql.=" AND (ts.no_faktur LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR ts.kode_barang LIKE '".$requestData['search']['value']."%'  ";  
    $sql.=" OR ts.nama_barang LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR ts.kode_barang_tujuan LIKE '".$requestData['search']['value']."%'  ";  
    $sql.=" OR ts.nama_barang_tujuan LIKE '".$requestData['search']['value']."%' )";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

 $sql.="  ORDER BY ts.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
            
    $nestedData[] = $no_faktur;            
    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];  
    $nestedData[] = $row["kode_barang_tujuan"];
    $nestedData[] = $row["nama_barang_tujuan"];
    $nestedData[] = $row["satuan"];
    $nestedData[] = $row['jumlah'];
    $nestedData[] = rp($row['harga']);
    $nestedData[] = rp($row['subtotal']);
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