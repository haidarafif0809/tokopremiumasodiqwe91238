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
    2=>'nama',
    3=>'kategori',
    4=>'suplier', 
    5=>'harga_beli', 
    6=>'satuan', 
    7=>'stok',
    8=>'jumlah_hpp_minus',
    9=>'jumlah_hpp_plus'



);


// getting total number records without any search
$sql ="SELECT s.nama,kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.stok_barang,b.satuan,b.kategori,b.suplier,b.harga_jual ";
$sql.="FROM barang b LEFT JOIN satuan s ON b.satuan = s.id ";
$sql.="WHERE b.berkaitan_dgn_stok = 'Barang' || b.berkaitan_dgn_stok = '' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql ="SELECT s.nama,kode_barang,b.nama_barang,b.satuan,b.harga_beli,b.stok_barang,b.satuan,b.kategori,b.suplier,b.harga_jual ";
$sql.="FROM barang b LEFT JOIN satuan s ON b.satuan = s.id ";
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

            //if ($selisih_fisik < 0) { // JIka selisih fisik nya minus maka harga yang diambil dari hpp masuk terakhir
           $pilih_hpp = $db->query("SELECT harga_unit FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]' ORDER BY id DESC LIMIT 1");
           $ambil_hpp = mysqli_fetch_array($pilih_hpp);


           // jumlah hpp/ harga unit dari hpp masuk
           $jumlah_hpp_minus = $ambil_hpp['harga_unit'];

            if ($jumlah_hpp_minus == '' OR $jumlah_hpp_minus == NULL ) {
            $jumlah_hpp_minus = 0;
            }  
           // dimasukan ke array nested data
           // 
           $nestedData[] = $jumlah_hpp_minus;

           
            //if ($selisih_fisik > 0) { // JIka selisih fisik lebih dari nol maka harga yang diambil dari pembelian terakhir atau dari barang
           $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$row[kode_barang]' ORDER BY id DESC LIMIT 1");
           $num_rows = mysqli_num_rows($select2);
           $fetc_array = mysqli_fetch_array($select2);
           
           $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$row[kode_barang]' ORDER BY id DESC LIMIT 1");
           $ambil_barang = mysqli_fetch_array($select3);
           
           // jika tidak ada pembelian maka yang diambil dari barang
           if ($num_rows == 0) {
           
           $jumlah_hpp_plus = $ambil_barang['harga_beli'];  
           if ($jumlah_hpp_plus == '' OR $jumlah_hpp_plus == NULL ) {
            $jumlah_hpp_plus = 0;
            }         
           // dimasukan ke array nested data

            $nestedData[] = $jumlah_hpp_plus;
           } 
           
           else {
            // jika ada pembelian maka yang diambil dari pembelian
           $jumlah_hpp_plus = $fetc_array['harga'];
            if ($jumlah_hpp_plus == '' OR $jumlah_hpp_plus == NULL ) {
            $jumlah_hpp_plus = 0;
            }   

             // dimasukan ke array nested data
            $nestedData[] = $jumlah_hpp_plus;
           }

    
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