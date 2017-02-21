<?php
include 'db.php';
include 'sanitasi.php';

$no_faktur = $_POST['no_faktur'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name
    
    0=>'no_faktur', 
    1=>'kode_barang',
    2=>'nama_barang',
    3=>'jumlah_barang',
    4=>'satuan',
    5=>'harga', 
    6=>'subtotal',
    7=>'potongan',
    8=>'tax',
    9=>'id'

);

// getting total number records without any search


$sql = "SELECT dp.id, dp.no_faktur, dp.kode_barang, dp.nama_barang, dp.jumlah_barang / sk.konversi AS jumlah_produk, dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, dp.sisa, sk.id_satuan, s.nama, sa.nama AS satuan_asal";
$sql.=" FROM detail_penjualan dp LEFT JOIN satuan_konversi sk ON dp.satuan = sk.id_satuan LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN satuan sa ON dp.asal_satuan = sa.id LEFT JOIN hpp_keluar hk ON dp.no_faktur = hk.no_faktur AND dp.kode_barang = hk.kode_barang ";
$sql.=" WHERE dp.no_faktur = '$no_faktur'";

$query=mysqli_query($conn, $sql) or die("1: get employees");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

$sql = "SELECT dp.id, dp.no_faktur, dp.kode_barang, dp.nama_barang, dp.jumlah_barang / sk.konversi AS jumlah_produk, dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, dp.sisa, sk.id_satuan, s.nama, sa.nama AS satuan_asal ";
$sql.=" FROM detail_penjualan dp LEFT JOIN satuan_konversi sk ON dp.satuan = sk.id_satuan LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN satuan sa ON dp.asal_satuan = sa.id LEFT JOIN hpp_keluar hk ON dp.no_faktur = hk.no_faktur AND dp.kode_barang = hk.kode_barang ";
$sql.=" WHERE dp.no_faktur = '$no_faktur' ";

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql.=" AND ( dp.kode_barang LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ) ";
} 

 $query=mysqli_query($conn, $sql) or die("2: get employees");
 $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


 $sql.=" ORDER BY dp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("3: get employees");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array

    $nestedData=array(); 
    
    $nestedData[] = $row["no_faktur"];
    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = rp($row["jumlah_barang"]);
    $nestedData[] = $row["satuan_asal"];
    $nestedData[] = rp($row["harga"]);
    $nestedData[] = rp($row["subtotal"]);
    $nestedData[] = rp($row["potongan"]);
    $nestedData[] = rp($row["tax"]);

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