<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

        
    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'jumlah_barang',
    3=>'kategori',
    4=>'suplier', 
    5=>'satuan', 
    6=>'harga', 
    7=>'id',


);


// getting total number records without any search
$sql = "SELECT b.id,s.nama,b.kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.satuan,b.kategori,b.suplier, b.berkaitan_dgn_stok, k.nama_kategori ";
$sql.=" FROM barang b INNER JOIN satuan s ON b.satuan = s.id INNER JOIN kategori k ON b.kategori = k.id WHERE b.berkaitan_dgn_stok = 'Barang' AND b.status = 'Aktif'";


$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = " SELECT b.id,s.nama,b.kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.satuan,b.kategori,b.suplier, b.berkaitan_dgn_stok, k.nama_kategori ";
$sql.="  FROM barang b INNER JOIN satuan s ON b.satuan = s.id INNER JOIN kategori k ON b.kategori = k.id";
$sql.=" WHERE 1=1 AND b.berkaitan_dgn_stok = 'Barang' AND b.status = 'Aktif'";

    $sql.=" AND (b.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.berkaitan_dgn_stok LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR b.satuan LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR k.nama_kategori LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.suplier LIKE '".$requestData['search']['value']."%' ) ";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY b.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

            $nestedData=array(); 

            $nestedData[] = $row["kode_barang"];
            $nestedData[] = $row["nama_barang"];

    // mencari jumlah Barang
            $stok_barang = cekStokHpp($row["kode_barang"]);

        
            $nestedData[] =  $stok_barang;
                  

            $nestedData[] =  $row["nama_kategori"];
            $nestedData[] =  $row["suplier"];
            $nestedData[] =  $row["nama"];
            $nestedData[] =  $row["harga_beli"];
            $nestedData[] =  $row["satuan"];

    
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