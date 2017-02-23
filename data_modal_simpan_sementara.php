<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_pelanggan', 
    1=>'nama_pelanggan',
    2=>'no_faktur',
    3=>'total',
    4=>'potongan',
    5=>'biaya_admin',
    6=>'tanggal',
    7=>'jam',
    8=>'id'


);

// getting total number records without any search
$sql = "SELECT p.potongan,p.biaya_admin,p.id,p.kode_pelanggan,p.no_faktur,p.total,p.tanggal,p.jam,pl.nama_pelanggan";
$sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan ";
$sql.=" WHERE p.status = 'Simpan Sementara'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT p.potongan,p.biaya_admin,p.id,p.kode_pelanggan,p.no_faktur,p.total,p.tanggal,p.jam,pl.nama_pelanggan";
$sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.kode_pelanggan ";
$sql.=" WHERE p.status = 'Simpan Sementara'";

    $sql.=" p.kode_pelanggan LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR p.no_faktur LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR p.total LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR p.jam LIKE '".$requestData['search']['value']."%'";     
    $sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%')";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY p.tanggal ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

   

    $nestedData=array(); 


    $nestedData[] = $row["kode_pelanggan"];
    $nestedData[] = $row["nama_pelanggan"];
    $nestedData[] = $row["no_faktur"];
    $nestedData[] = rp($row["total"]);
    $nestedData[] = rp($row["potongan"]);
    $nestedData[] = rp($row["biaya_admin"]);
    $nestedData[] = $row["tanggal"];
    $nestedData[] = $row["jam"];
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