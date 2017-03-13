<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$pelanggan = angkadoang($_POST['pelanggan']);

    //menampilkan seluruh data yang ada pada tabel penjualan
    $perintah = $db->query("SELECT lama_tidak_aktif,aktif_kembali,satuan_tidak_aktif FROM setting_member");
    $ambil = mysqli_fetch_array($perintah);

    $satuan_tidak_aktif = $ambil['satuan_tidak_aktif']; 
    $lama_tidak_aktif = $ambil['lama_tidak_aktif']; 
    $aktif_kembali = $ambil['aktif_kembali'];
    $nol = 0;



$requestData= $_REQUEST;

$columns = array( 
// datatable column index  => database column name

    0=>'no_faktur', 
    1=>'pelanggan',
    2=>'total',
    3=>'tanggal'


);


if ($satuan_tidak_aktif == 1) {

// getting total number records without any search
$sql = "SELECT p.no_faktur,p.kode_pelanggan AS id_pelanggan,p.tanggal, p.total, pl.nama_pelanggan ,pl.kode_pelanggan AS kode_pelanggan";
$sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id ";
$sql.=" WHERE p.kode_pelanggan = '$pelanggan' AND p.tanggal > DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' MONTH)";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


        if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                                                          
        $sql = "SELECT p.no_faktur,p.kode_pelanggan AS id_pelanggan,p.tanggal, p.total, pl.nama_pelanggan, pl.kode_pelanggan AS kode_pelanggan";
        $sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id";
        $sql.="  WHERE p.kode_pelanggan = '$pelanggan' AND p.tanggal > DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' MONTH) ";

            $sql.=" AND (p..no_faktur LIKE '".$requestData['search']['value']."%' ";
            $sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%'  ";  
            $sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
            $sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' )";  
        }



}
else if ($satuan_tidak_aktif == 2)
{
   // getting total number records without any search
$sql = "SELECT p.no_faktur,p.kode_pelanggan AS id_pelanggan ,p.tanggal, p.total, pl.nama_pelanggan, pl.kode_pelanggan AS kode_pelanggan";
$sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id ";
$sql.=" WHERE p.kode_pelanggan = '$pelanggan' AND p.tanggal > DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' YEAR)";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


        if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
                                                          
        $sql = "SELECT p.no_faktur,p.kode_pelanggan AS id_pelanggan ,p.tanggal, p.total, pl.nama_pelanggan ,pl.kode_pelanggan AS kode_pelanggan";
        $sql.=" FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id";
        $sql.="  WHERE p.kode_pelanggan = '$pelanggan' AND p.tanggal > DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' YEAR) ";

            $sql.=" AND (p..no_faktur LIKE '".$requestData['search']['value']."%' ";
            $sql.=" OR p.tanggal LIKE '".$requestData['search']['value']."%'  ";  
            $sql.=" OR pl.nama_pelanggan LIKE '".$requestData['search']['value']."%' ";
            $sql.=" OR pl.kode_pelanggan LIKE '".$requestData['search']['value']."%' )";  
        }
 
}



$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql.=" ORDER BY p.tanggal ASC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


if ($satuan_tidak_aktif == 1) {

// getting total number records without any search
$bulan = $db->query("SELECT p.no_faktur,p.kode_pelanggan AS id_pelanggan,p.tanggal, p.total, pl.nama_pelanggan ,pl.kode_pelanggan AS kode_pelanggan FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id WHERE p.kode_pelanggan = '$pelanggan' AND p.tanggal <= DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' MONTH)  ORDER BY p.tanggal DESC LIMIT 1  ");
$tampil = mysqli_fetch_array($bulan);
  $satuan_tidak_aktif = "Bulan";

}
else if ($satuan_tidak_aktif == 2)
{

// getting total number records without any search
$tahun = $db->query("SELECT p.no_faktur,p.kode_pelanggan AS id_pelanggan,p.tanggal, p.total, pl.nama_pelanggan ,pl.kode_pelanggan AS kode_pelanggan FROM penjualan p LEFT JOIN pelanggan pl ON p.kode_pelanggan = pl.id  WHERE p.kode_pelanggan = '$pelanggan' AND p.tanggal <= DATE_SUB(CURDATE(), INTERVAL '$lama_tidak_aktif' YEAR) ORDER BY p.tanggal DESC LIMIT 1 ");
$tampil = mysqli_fetch_array($tahun);

$satuan_tidak_aktif = "Tahun";
}

$data = array();

    $nestedData=array(); 
             
    $nestedData[] = $tampil["no_faktur"];
    $nestedData[] = $tampil["kode_pelanggan"]." || ". $tampil['nama_pelanggan'];
    $nestedData[] = rp($tampil['total']);
    $nestedData[] = $tampil['tanggal'];
    $nestedData[] = "<p style='color: red'>Belanja " . $lama_tidak_aktif . " " . $satuan_tidak_aktif ." Yang Lalu</p>" ;

                    

    $data[] = $nestedData;
        


while($row=mysqli_fetch_array($query) ) {

    $nestedData=array(); 

    $nol = $nol + 1;

    $nestedData[] = $row["no_faktur"];
    $nestedData[] = $row["kode_pelanggan"]." || ". $row['nama_pelanggan'];
    $nestedData[] = rp($row['total']);
    $nestedData[] = $row['tanggal'];
    $nestedData[] = $nol . " Kali Belanja (Setelah ".$lama_tidak_aktif . " " . $satuan_tidak_aktif.")";
                    

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