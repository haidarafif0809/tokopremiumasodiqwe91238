<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */


$dari_tgl = stringdoang($_POST['dari_tanggal']);
$sampai_tgl = stringdoang($_POST['sampai_tanggal']);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'satuan',
    3=>'penjualan_periode',
    4=>'penjulan_perhari',
    5=>'stok',
    6=>'stok_habis'


);


// getting total number records without any search
$sql = "SELECT dp.kode_barang, dp.nama_barang, dp.satuan, s.nama ";
$sql.=" FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id ";
$sql.="  WHERE dp.tanggal >= '$dari_tgl' AND dp.tanggal <= '$sampai_tgl' ";
$sql.=" GROUP BY dp.kode_barang ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT dp.kode_barang, dp.nama_barang, dp.satuan, s.nama ";
$sql.=" FROM detail_penjualan dp LEFT JOIN satuan s ON dp.satuan = s.id";
$sql.=" WHERE dp.tanggal >= '$dari_tgl' AND dp.tanggal <= '$sampai_tgl' ";

    $sql.=" AND (dp.kode_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' ) GROUP BY dp.kode_barang ";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

 $sql.=" ORDER BY SUM(dp.jumlah_barang) DESC LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");

$data = array();
while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 
   
            $zxc = $db->query("SELECT SUM(jumlah_barang) AS jumlah_periode FROM detail_penjualan  WHERE kode_barang = '$row[kode_barang]' AND tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ");
            $qewr = mysqli_fetch_array($zxc);

            $select = $db->query("SELECT SUM(sisa) AS stok FROM hpp_masuk WHERE kode_barang = '$row[kode_barang]'");
                $ambil_sisa = mysqli_fetch_array($select);


            //hitung hari
            $datetime1 = new DateTime($dari_tgl);
            $datetime2 = new DateTime($sampai_tgl);
            $difference = $datetime1->diff($datetime2);
            $difference->days;

            // hitung jumlah rata2 perhari
            $jumlah_perhari = $qewr['jumlah_periode'] / $difference->days;

            // hitung stok habis(hari)
            $stok_habis = $ambil_sisa['stok'] / round($jumlah_perhari);

    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = $row["nama"];
    $nestedData[] = rp($qewr['jumlah_periode']);
    $nestedData[] = rp(round($jumlah_perhari));
    $nestedData[] = rp($ambil_sisa['stok']);
    $nestedData[] = rp(round($stok_habis));
                    


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