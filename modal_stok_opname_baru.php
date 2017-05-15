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
    2=>'jumlah_barang',
    3=>'kategori',
    4=>'suplier', 
    5=>'satuan', 
    6=>'harga_beli', 
    7=>'id',



);


// getting total number records without any search
$sql ="SELECT s.nama,kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.stok_barang,b.satuan,b.kategori,b.suplier,b.harga_jual ";
$sql.="FROM barang b INNER JOIN satuan s ON b.satuan = s.id ";
$sql.="WHERE b.berkaitan_dgn_stok = 'Barang' || b.berkaitan_dgn_stok = '' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql ="SELECT s.nama,kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.stok_barang,b.satuan,b.kategori,b.suplier,b.harga_jual ";
$sql.="FROM barang b INNER JOIN satuan s ON b.satuan = s.id ";
$sql.="WHERE b.berkaitan_dgn_stok = 'Barang' ";

    $sql.=" AND (b.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR b.kategori LIKE '".$requestData['search']['value']."%'";   
    $sql.=" OR b.status LIKE '".$requestData['search']['value']."%' ) ";


}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY b.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 


    // mencari jumlah Barang
            $select = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_hpp_masuk FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
            $ambil_masuk = mysqli_fetch_array($select);
             
            $select_2 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_hpp_keluar FROM hpp_keluar WHERE kode_barang = '$row[kode_barang]'");
            $ambil_keluar = mysqli_fetch_array($select_2);
             
            $stok_barang = $ambil_masuk['jumlah_hpp_masuk'] - $ambil_keluar['jumlah_hpp_keluar'];
            

            $nestedData[] = $row["kode_barang"];
            $nestedData[] = $row["nama_barang"];
            $nestedData[] = $row["nama"];
            $nestedData[] = $row["kategori"];
            $nestedData[] = $row["suplier"];
            $nestedData[] = $row["harga_beli"];
            $nestedData[] = $row["satuan"];
            $nestedData[] = $stok_barang;

    
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