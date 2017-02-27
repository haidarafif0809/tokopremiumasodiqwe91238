<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$no_faktur = stringdoang($_POST['no_faktur']);


// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'id', 
    1=>'no_faktur',
    2=>'kode_barang',
    3=>'nama_barang',
    4=>'jumlah_barang', 
    5=>'jumlah_barang',
    6=>'satuan',
    7=>'harga',
    8=>'potongan', 
    9=>'subtotal',
    10=>'tax',
    11=>'sisa',
    12=>'nama',
    13=>'nama'

);

// getting total number records without any search
$sql =" SELECT dp.id, dp.no_faktur, dp.kode_barang, dp.nama_barang, dp.jumlah_barang , dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, dp.sisa, s.nama, sa.nama AS satuan_asal";
$sql.=" FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan sa ON dp.asal_satuan = sa.id";
$sql.=" WHERE dp.no_faktur = '$no_faktur'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT dp.id, dp.no_faktur, dp.kode_barang, dp.nama_barang, dp.jumlah_barang , dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, dp.sisa, s.nama, sa.nama AS satuan_asal";
$sql.=" FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan sa ON dp.asal_satuan = sa.id";
$sql.=" WHERE dp.no_faktur = '$no_faktur'";

    $sql.=" AND (dp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY dp.kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array();

                   $ambil_hpp = $db->query("SELECT SUM(sisa) AS sisa_hpp FROM hpp_masuk WHERE no_faktur = '$no_faktur' AND kode_barang = '$row[kode_barang]'");
                   $data_hpp = mysqli_fetch_array($ambil_hpp);
                   
                   $pilih_konversi = $db->query("SELECT $row[jumlah_barang] / sk.konversi AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$row[satuan]' AND sk.kode_produk = '$row[kode_barang]'");
                   $data_konversi = mysqli_fetch_array($pilih_konversi);
                   
                   if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
                   
                   $jumlah_barang = $data_konversi['jumlah_konversi'];
                   }
                   else{
                   
                   $jumlah_barang = $row['jumlah_barang'];
                   }

          $nestedData[] = $row['no_faktur'];
          $nestedData[] = $row['kode_barang'];
          $nestedData[] = $row['nama_barang'];
          $nestedData[] = $jumlah_barang;
          $nestedData[] = $row['nama'];
          $nestedData[] = rp($row['harga']);
          $nestedData[] = rp($row['subtotal']);
          $nestedData[] = rp($row['potongan']);
          $nestedData[] = rp($row['tax']);
          $nestedData[] = $data_hpp['sisa_hpp'] ." ".$row['satuan_asal'];

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