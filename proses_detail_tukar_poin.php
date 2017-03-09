<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_faktur = stringdoang($_POST['no_faktur']);


$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'satuan',
    3=>'penjualan_periode',
    4=>'penjulan_perhari',
    5=>'target',
    6=>'proyeksi',
    7=>'stok',
    8=>'kebutuhan'


);

// getting total number records without any search
$sql = "SELECT dt.no_faktur, dt.kode_barang, dt.nama_barang, dt.jumlah_barang, dt.poin, dt.subtotal_poin, s.nama";
$sql.=" FROM detail_tukar_poin dt LEFT JOIN satuan s ON dt.satuan = s.id ";
$sql.="  WHERE dt.no_faktur = '$no_faktur'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT dt.no_faktur, dt.kode_barang, dt.nama_barang, dt.jumlah_barang, dt.poin, dt.subtotal_poin, s.nama";
$sql.=" FROM detail_tukar_poin dt LEFT JOIN satuan s ON dt.satuan = s.id ";
$sql.="  WHERE dt.no_faktur = '$no_faktur'";

    $sql.=" AND (dt.kode_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%'  ";  
    $sql.=" OR dt.nama_barang LIKE '".$requestData['search']['value']."%' )";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY dt.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
             

    $nestedData[] = $no_faktur;   
    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = $row["nama"];
    $nestedData[] = rp($row['jumlah_barang']);
    $nestedData[] = rp($row['poin']);
    $nestedData[] = rp($row['subtotal_poin']);
                    

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