<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */
$program = $_POST['id_programnya'];
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_produk',
    2=>'nama_program',
    3=>'id',


);

// getting total number records without any search
$sql = "SELECT b.id,b.harga_jual,b.nama_barang,b.satuan as satuan_barang,b.kode_barang,pp.nama_produk,pp.nama_program,pp.satuan,pp.qty, pp.id,p.nama_program as program ";
$sql.=" FROM promo_free_produk pp LEFT JOIN barang b ON pp.nama_produk = b.id LEFT JOIN program_promo p ON pp.nama_program = p.id where pp.nama_program = '$program' AND pp.qty != '0'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT b.id,b.harga_jual,b.nama_barang,b.satuan as satuan_barang,b.kode_barang,pp.nama_produk,pp.nama_program,pp.satuan,pp.qty, pp.id,p.nama_program as program";
$sql.="FROM promo_free_produk pp LEFT JOIN barang b ON pp.nama_produk = b.id LEFT JOIN program_promo p ON pp.nama_program = p.id WHERE pp.nama_program = '$program' AND pp.qty != '0' AND 1=1 ";

    $sql.=" AND ( b.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' )"; 

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY pp.id DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 

    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = $row["program"];
    $nestedData[] = $row["qty"];
    $nestedData[] = $row["satuan_barang"];
    $nestedData[] = $row["harga_jual"];
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