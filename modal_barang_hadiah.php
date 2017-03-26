<?php include 'session_login.php';
/* Database connection start */
include 'db.php';
/* Database connection end */
include 'sanitasi.php';


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name
    0 =>'kode',
    1 =>'nama',
    2 =>'satuan',
    3 =>'poin',
    4 =>'id_satuan'
);


// getting total number records without any search
$sql = "SELECT mp.id,mp.kode_barang,mp.nama_barang,mp.quantity_poin,s.nama , s.id AS id_satuan";
$sql.=" FROM master_poin mp LEFT JOIN satuan s ON mp.satuan = s.id ";
$query=mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT mp.id,mp.kode_barang,mp.nama_barang,mp.quantity_poin,s.nama , s.id AS id_satuan";
$sql.=" FROM master_poin mp LEFT JOIN satuan s ON mp.satuan = s.id WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter


    $sql.=" AND ( mp.kode_barang LIKE '".$requestData['search']['value']."%' "; 
    $sql.=" OR mp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}
$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.= " ORDER BY mp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array(); 

        //menampilkan data
            $nestedData[] = $row['kode_barang'];
            $nestedData[] = $row['nama_barang'];
            $nestedData[] = $row['nama'];
            $nestedData[] = rp($row['quantity_poin']);
            $nestedData[] = $row["id_satuan"];
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

