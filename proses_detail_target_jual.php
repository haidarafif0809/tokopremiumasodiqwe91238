<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_trx = stringdoang($_POST['no_trx']);

$x = 0;

$requestData= $_REQUEST;

if ($requestData['start'] > 0) 
{   
$x = $x + $requestData['start'];

}
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
$sql = "SELECT dp.id,dp.jumlah_periode,dp.jual_perhari,dp.target_perhari,dp.proyeksi,dp.stok_terakhir,dp.kebutuhan,dp.kode_barang, dp.nama_barang, dp.satuan, s.nama  ";
$sql.=" FROM detail_target_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id ";
$sql.=" WHERE dp.no_trx = '$no_trx' GROUP BY dp.kode_barang";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT dp.id,dp.jumlah_periode,dp.jual_perhari,dp.target_perhari,dp.proyeksi,dp.stok_terakhir,dp.kebutuhan,dp.kode_barang, dp.nama_barang, dp.satuan, s.nama  ";
$sql.=" FROM detail_target_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id ";
$sql.=" WHERE dp.no_trx = '$no_trx' ";

    $sql.=" AND (dp.kode_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%'  ";  
    $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ) GROUP BY dp.kode_barang";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

 $sql.="  ORDER BY dp.jumlah_periode DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
             

            $x = $x + 1;

    $nestedData[] = $x .".";      
    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = $row["nama"];
    $nestedData[] = rp($row['jumlah_periode']);
    $nestedData[] = rp($row['jual_perhari']);
    $nestedData[] = rp($row['target_perhari']);

    $nestedData[] = rp($row['proyeksi']);

    $nestedData[] = rp($row['stok_terakhir']);

    $nestedData[] = rp($row['kebutuhan']);
                    


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