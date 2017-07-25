<?php
include 'db.php';
include 'sanitasi.php';

$no_faktur = $_POST['no_faktur'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    
    0=>'no_faktur', 
    1=>'kode_produk',
    2=>'nama_produk',
    3=>'qty_bonus',
    4=>'satuan',
    5=>'harga_disc', 
    6=>'subtotal',
    7=>'id'

);

// getting total number records without any search


$sql = "SELECT  bp.no_faktur_penjualan,bp.kode_produk,bp.nama_produk,bp.qty_bonus,s.nama as nama_satuan,bp.harga_disc,bp.subtotal,bp.keterangan,bp.id";
$sql.=" FROM bonus_penjualan bp INNER JOIN satuan s ON bp.satuan = s.id WHERE bp.no_faktur_penjualan = '$no_faktur'";

$query=mysqli_query($conn, $sql) or die("1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT bp.no_faktur_penjualan,bp.kode_produk,bp.nama_produk,bp.qty_bonus,s.nama as nama_satuan,bp.harga_disc,bp.subtotal,bp.keterangan,bp.id";
$sql.=" FROM bonus_penjualan bp INNER JOIN satuan s ON bp.satuan = s.id WHERE bp.no_faktur_penjualan = '$no_faktur'";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( bp.kode_produk LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR bp.nama_produk LIKE '".$requestData['search']['value']."%' ) ";
} 

 $query=mysqli_query($conn, $sql) or die("2: get employees");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


 $sql.=" ORDER BY bp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

    $nestedData=array(); 
    
    $nestedData[] = $row["no_faktur_penjualan"];
    $nestedData[] = $row["kode_produk"];
    $nestedData[] = $row["nama_produk"];
    $nestedData[] = koma($row["qty_bonus"],3);
    $nestedData[] = $row["nama_satuan"];
    $nestedData[] = koma($row["harga_disc"],2);
    $nestedData[] = koma($row["subtotal"],2);
    $nestedData[] = $row["keterangan"];
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