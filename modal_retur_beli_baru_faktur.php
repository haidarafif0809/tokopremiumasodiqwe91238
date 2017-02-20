<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$nama_suplier = $_POST['suplier'];

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

  0=>'kode_barang', 
  1=>'nama_barang',
  2=>'satuan',
  3=>'no_faktur',
  4=>'jumlah_barang',
  5=>'id_produk', 
  6=>'asal_satuan',
  7=>'harga',
  8=>'nama',
  9=>'subtotal',
  10=>'potongan', 
  11=>'tax',
  12=>'sisa',
  13=>'id'


);

// getting total number records without any search
$sql = "SELECT b.id AS id_produk,b.satuan AS satuan_dasar, s.nama AS satuan_beli ,ss.nama AS satuan_asli, dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, p.suplier, hm.harga_unit, IFNULL(SUM(hpm.sisa),0) + IFNULL(hm.sisa,0) AS sisa, dp.satuan, dp.asal_satuan ";
$sql.=" FROM detail_pembelian dp LEFT JOIN pembelian p ON dp.no_faktur = p.no_faktur LEFT JOIN hpp_masuk hm ON dp.no_faktur = hm.no_faktur AND dp.kode_barang = hm.kode_barang LEFT JOIN hpp_masuk hpm ON dp.no_faktur = hpm.no_faktur_hpp_masuk AND dp.kode_barang = hpm.kode_barang INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id INNER JOIN barang b ON dp.kode_barang = b.kode_barang ";
$sql.=" WHERE (hpm.sisa > 0 OR hm.sisa > 0) ";
$sql.=" AND p.suplier = '$nama_suplier' GROUP BY dp.no_faktur, dp.kode_barang";
$sql.=" ";

$query = mysqli_query($conn, $sql) or die("Salahnya Ada Disini 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql = "SELECT b.id AS id_produk,b.satuan AS satuan_dasar, s.nama AS satuan_beli ,ss.nama AS satuan_asli, dp.no_faktur, dp.tanggal, dp.kode_barang, dp.nama_barang, dp.jumlah_barang, dp.satuan, dp.harga, dp.subtotal, dp.potongan, dp.tax, dp.status, p.suplier, hm.harga_unit, IFNULL(SUM(hpm.sisa),0) + IFNULL(hm.sisa,0) AS sisa, dp.satuan, dp.asal_satuan ";
$sql.=" FROM detail_pembelian dp LEFT JOIN pembelian p ON dp.no_faktur = p.no_faktur LEFT JOIN hpp_masuk hm ON dp.no_faktur = hm.no_faktur AND dp.kode_barang = hm.kode_barang LEFT JOIN hpp_masuk hpm ON dp.no_faktur = hpm.no_faktur_hpp_masuk AND dp.kode_barang = hpm.kode_barang INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id INNER JOIN barang b ON dp.kode_barang = b.kode_barang ";
$sql.=" WHERE (hpm.sisa > 0 OR hm.sisa > 0) ";
$sql.=" AND p.suplier = '$nama_suplier'";

$sql.=" AND ( dp.kode_barang LIKE '".$requestData['search']['value']."%' ";  
$sql.=" OR dp.nama_barang LIKE '".$requestData['search']['value']."%')";

$sql.=" GROUP BY dp.no_faktur, dp.kode_barang ";

}

$query=mysqli_query($conn, $sql) or die("Salahnya Ada Disini 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
    
$sql.=" ORDER BY dp.id ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */  
$query=mysqli_query($conn, $sql) or die("Salahnya Ada Disini 3");


$data = array();


while( $row=mysqli_fetch_array($query) ) {


$sum_sisa = $db->query("SELECT IFNULL(SUM(sisa),0) AS jumlah_sisa_produk FROM hpp_masuk WHERE sisa > 0 AND kode_barang = '$row[kode_barang]' AND (jenis_transaksi = 'Pembelian' OR jenis_transaksi = 'Retur Penjualan') ");
$data_sum_sisa = mysqli_fetch_array($sum_sisa);


      //menampilkan konversi dari satuan_konversi
      $konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$row[satuan]' AND kode_produk = '$row[kode_barang]'");
      $data_konversi = mysqli_fetch_array($konversi);
      $num_rows = mysqli_num_rows($konversi);

     if ($num_rows > 0) {
        
     $sisa = $row['sisa'] % $data_konversi['konversi'];
     $jumlah_barang = $row['jumlah_barang'] / $data_konversi['konversi'];
     $harga = $row['harga'] * $data_konversi['konversi'];

      }
      else{

        $sisa = $row['sisa'];
        $harga = $row['harga'];
        $jumlah_barang = $row['jumlah_barang'];
        
      }

  $nestedData=array(); 


  $nestedData[] = $row["no_faktur"];
  $nestedData[] = $row["kode_barang"];
  $nestedData[] = $row["nama_barang"];
  $nestedData[] = "$jumlah_barang";
  $nestedData[] = $row["satuan_beli"];

  if ($sisa == 0) {
    $nestedData[] = rp("$harga");
      }
  else{
    $nestedData[] = rp($row["harga"]);

  }

  $nestedData[] = rp($row["subtotal"]);

  if ($sisa == 0) {
      $konversi_data = $row['sisa'] / $data_konversi['konversi'];
       $nestedData[] = $konversi_data ." ". $row["satuan_beli"] ;
    }
  else{
         $nestedData[] = rp($row["sisa"]) ." ". $row["satuan_asli"] ;
    }

  $nestedData[] = $row["harga"];
  $nestedData[] = $row["asal_satuan"];
  $nestedData[] = "$sisa";
  $nestedData[] = $row["id_produk"];
  $nestedData[] = $row["satuan"];
  $nestedData[] = $row["sisa"];  
  $nestedData[] = $row["no_faktur"];
  $nestedData[] = $row["satuan_dasar"];
  $nestedData[] = $row["harga"];

  
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