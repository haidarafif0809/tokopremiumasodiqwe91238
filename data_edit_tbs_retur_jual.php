<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

/* Database connection end */

$no_faktur_retur = stringdoang($_POST['no_faktur_retur']);

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'kode_barang', 
    1=>'nama_barang',
    2=>'jumlah_barang',
    3=>'satuan',
    4=>'harga',
    5=>'subtotal',
    6=>'potongan',
    7=>'tax',
    8=>'jam',
    9=>'id',
    9=>'dosis'    

);

// getting total number records without any search
$sql =" SELECT tp.id, tp.no_faktur_penjualan, tp.nama_barang, tp.kode_barang, tp.jumlah_beli, tp.jumlah_retur, tp.satuan, tp.harga, tp.harga, tp.potongan, tp.tax, tp.subtotal, s.nama AS satuan_retur,ss.nama AS satuan_jual";
$sql.=" FROM tbs_retur_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id INNER JOIN satuan ss ON tp.satuan_jual = ss.id";
$sql.=" WHERE tp.no_faktur_retur = '$no_faktur_retur'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.id, tp.no_faktur_penjualan, tp.nama_barang, tp.kode_barang, tp.jumlah_beli, tp.jumlah_retur, tp.satuan, tp.harga, tp.harga, tp.potongan, tp.tax, tp.subtotal, s.nama AS satuan_retur,ss.nama AS satuan_jual";
$sql.=" FROM tbs_retur_penjualan tp INNER JOIN satuan s ON tp.satuan = s.id INNER JOIN satuan ss ON tp.satuan_jual = ss.id";
$sql.=" WHERE tp.no_faktur_retur = '$no_faktur_retur'";

    $sql.=" AND (tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}

$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.kode_barang DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $nestedData[] = $row["no_faktur_penjualan"];
      $nestedData[] = $row["nama_barang"];
      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["jumlah_beli"];
      $nestedData[] = $row["satuan_jual"];

      $nestedData[] = "<p class='edit-jumlah' data-id='".$row['id']."' data-faktur='".$row['no_faktur_penjualan']."' data-kode='".$row['kode_barang']."'> <span id='text-jumlah-".$row['id']."'> ".koma($row['jumlah_retur'],2)." </span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".koma($row['jumlah_retur'],2)."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-faktur='".$row['no_faktur_penjualan']."' data-kode='".$row['kode_barang']."' data-harga='".$row['harga']."' data-satuan='".$row['satuan']."'> </p>";

      $nestedData[] = $row["satuan_retur"];
      $nestedData[] = "<p  align='right'>".rp($row["harga"])."</p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-potongan-".$row['id']."'> ".rp($row["potongan"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-tax-".$row['id']."'> ".rp($row["tax"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".rp($row["subtotal"])." </span> </p>";

      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='btn-hapus-".$row['id']."' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-faktur='". $row['no_faktur_penjualan'] ."' data-subtotal='". $row['subtotal'] ."'> Hapus </button>";

      $nestedData[] = $row["id"];

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