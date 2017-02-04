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
    5=>'stok'


);


// getting total number records without any search
$sql = "SELECT kode_barang";
$sql.=" FROM detail_penjualan ";
$sql.="  WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ";
$sql.=" GROUP BY kode_barang ";
$sql.=" ORDER BY SUM(jumlah_barang) DESC LIMIT 10  ";
$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter

$sql = "SELECT kode_barang";
$sql.=" FROM detail_penjualan ";
$sql.=" WHERE tanggal >= '$dari_tgl' AND tanggal <= '$sampai_tgl' ";

    $sql.=" AND (kode_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR nama_barang LIKE '".$requestData['search']['value']."%' ) GROUP BY kode_barang ORDER BY SUM(jumlah_barang) DESC LIMIT 10";  
}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 


while( $row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 

          $bb = $db->query("SELECT b.nama_barang, s.nama AS nama_satuan FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kode_barang = '$row[kode_barang]' ");
            $data_barang = mysqli_fetch_array($bb);
   
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

    $nestedData[] = $row["kode_barang"];
    $nestedData[] = $data_barang["nama_barang"];
    $nestedData[] = $data_barang["nama_satuan"];
    $nestedData[] = rp($qewr['jumlah_periode']);
    $nestedData[] = rp(round($jumlah_perhari));
    $nestedData[] = rp($ambil_sisa['stok']);
                    


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