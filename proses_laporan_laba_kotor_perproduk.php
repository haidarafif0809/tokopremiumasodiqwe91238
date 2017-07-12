<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */


$dari_tgl = stringdoang($_POST['dari_tanggal']);
$sampai_tgl = stringdoang($_POST['sampai_tanggal']);
$jumlah_data = 0;
// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;


$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'jumlah_barang',
    3=>'total_penjualan',
    4=>'total_hpp',
    5=>'total_potongan',
    6=>'total_laba',
    7=>'persentase_laba'
   


);
// getting total number records without any search
$sql_data = "SELECT count(*)  AS jumlah_data ";
$sql_data.=" FROM detail_penjualan  WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' GROUP BY kode_barang";
                              
$sql = "SELECT kode_barang , nama_barang , SUM(jumlah_barang) AS jumlah_barang, SUM(subtotal) AS total_penjualan , IFNULL(SUM(potongan),0) AS total_potongan,";
$sql.=" (SELECT IFNULL( SUM(total_nilai),0) AS total_hpp FROM hpp_keluar WHERE kode_barang = detail_penjualan.kode_barang AND hpp_keluar.tanggal >= '$dari_tgl' AND hpp_keluar.tanggal <= '$sampai_tgl' AND hpp_keluar.jenis_transaksi = 'Penjualan') AS total_hpp, ";//total hpp
$sql.=" SUM(subtotal) - (SELECT IFNULL( SUM(total_nilai),0) AS total_hpp FROM hpp_keluar WHERE kode_barang = detail_penjualan.kode_barang AND hpp_keluar.tanggal >= '$dari_tgl' AND hpp_keluar.tanggal <= '$sampai_tgl' AND hpp_keluar.jenis_transaksi = 'Penjualan') AS total_laba ";// total laba
$sql.=" FROM detail_penjualan WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl'";

 
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                                                  
    $sql.=" AND (kode_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR nama_barang LIKE '".$requestData['search']['value']."%' ) "; 

    $sql_data.=" AND (kode_barang LIKE '".$requestData['search']['value']."%' ";
    $sql_data.=" OR nama_barang LIKE '".$requestData['search']['value']."%' ) "; 

}


$sql.= "GROUP BY detail_penjualan.kode_barang ORDER BY SUM(subtotal) - total_hpp DESC  LIMIT ".$requestData['start']." ,".$requestData['length']."  ";

$query_data = $db->query($sql_data);
while ($query_jumlah_data = mysqli_fetch_array($query_data)) {
    $jumlah_data = $jumlah_data + 1;
}

$totalData = $jumlah_data;

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = $jumlah_data;; // when there is a search parameter then we have to modify total number filtered rows as per search result. 
   

$data = array();


while($row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 

    // persentase labe
    // (total laba / total penjualan) * 100
    $persentase_laba = ($row['total_laba'] / $row['total_penjualan']) * 100;

    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $row["nama_barang"];
    $nestedData[] = "<p align='right'>".rp($row["jumlah_barang"])."</p>";
    $nestedData[] = "<p align='right'>".rp($row['total_penjualan'])."</p>";
    $nestedData[] = "<p align='right'>".rp($row['total_hpp'])."</p>";
    $nestedData[] = "<p align='right'>".rp($row['total_potongan'])."</p>";
    $nestedData[] = "<p align='right'>".rp($row['total_laba'])."</p>";
    $nestedData[] = "<p align='right'>".round($persentase_laba,2)."%</p>";              

    $data[] = $nestedData;

}

$json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalData ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data  // total data array                       
            );

echo json_encode($json_data);  // send data as json format

 ?>


