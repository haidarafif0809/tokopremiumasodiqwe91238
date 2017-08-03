<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    
    0=>'kode_barang',
    1=>'nama_barang',
    2=>'harga_beli',
    3=>'nama', 
    4=>'kategori',
    5=>'suplier',
    6=>'satuan',
    7=>'over_stok',
    8=>'id',


);

// getting total number records without any search
$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.harga_beli, b.satuan, b.kategori, b.suplier, b.over_stok, b.stok_barang, sk.harga_pokok, s.nama, k.nama_kategori ";
$sql.=" FROM barang b LEFT JOIN satuan_konversi sk ON b.id = sk.id_produk LEFT JOIN satuan s ON b.satuan = s.id INNER JOIN kategori k ON b.kategori = k.id ";
$sql.=" WHERE b.berkaitan_dgn_stok = 'Barang'";

$query = mysqli_query($conn, $sql) or die("Salahnya Disini 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   
// if there is a search parameter, $requestData['search']['value'] contains search parameter
   
$sql =" SELECT b.id, b.kode_barang, b.nama_barang, b.harga_beli, b.satuan, b.kategori, b.suplier, b.over_stok, b.stok_barang, sk.harga_pokok, s.nama, k.nama_kategori ";
$sql.=" FROM barang b LEFT JOIN satuan_konversi sk ON b.id = sk.id_produk LEFT JOIN satuan s ON b.satuan = s.id INNER JOIN kategori k ON b.kategori = k.id ";
$sql.=" WHERE b.berkaitan_dgn_stok = 'Barang'";

    $sql.=" AND (b.kode_barang LIKE '".$requestData['search']['value']."%' ";    
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR k.nama_kategori LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.suplier LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' ) ";

}


$query=mysqli_query($conn, $sql) or die("Salahnya Disini 2");
$totalFiltered = mysqli_num_rows($query); 
// when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("Salahnya Disini 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

    // mencari jumlah Barang
            $select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
            $ambil_sisa = mysqli_fetch_array($select);
            
            $stok_barang = $ambil_sisa['jumlah_barang'];

            

    $nestedData=array(); 

    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = $row["harga_beli"];
    $nestedData[] = koma($stok_barang, 2);
    $nestedData[] = $row["nama"];
    $nestedData[] = $row["nama_kategori"];
    $nestedData[] = $row["suplier"];
    $nestedData[] = $row["satuan"];
    $nestedData[] = $row["over_stok"];
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