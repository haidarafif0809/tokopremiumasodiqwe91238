<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

/* Database connection end */

$no_faktur = stringdoang($_POST['no_faktur']);
$kode_parcel = stringdoang($_POST['kode_parcel']);
$jumlah_parcel = stringdoang($_POST['jumlah_parcel']);

if ($jumlah_parcel == "") {
  $jumlah_parcel = 0;
}

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;



$columns = array( 
// datatable column index  => database column name

    0=>'id', 
    1=>'id_parcel',
    2=>'id_produk',
    3=>'jumlah_produk'

);

// getting total number records without any search
$sql =" SELECT tp.id, tp.kode_parcel, tp.harga_produk, tp.id_produk, tp.jumlah_produk, b.kode_barang, b.nama_barang, b.satuan, s.nama";
$sql.=" FROM tbs_parcel tp INNER JOIN barang b ON tp.id_produk = b.id INNER JOIN satuan s ON b.satuan = s.id";
$sql.=" WHERE tp.kode_parcel = '$kode_parcel' AND tp.no_faktur = '$no_faktur'";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql =" SELECT tp.id, tp.kode_parcel, tp.harga_produk, tp.id_produk, tp.jumlah_produk, b.kode_barang, b.nama_barang, b.satuan, s.nama";
$sql.=" FROM tbs_parcel tp INNER JOIN barang b ON tp.id_produk = b.id INNER JOIN satuan s ON b.satuan = s.id";
$sql.=" WHERE tp.kode_parcel = '$kode_parcel' AND tp.no_faktur = '$no_faktur'";

    $sql.=" AND (b.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR b.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY kode_barang ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 

      $jumlah_produk_tampil = koma($row["jumlah_produk"],2);
      $dibelakang_koma = substr($jumlah_produk_tampil, -4);
      $total_hpp = hitungHppProduk($row['kode_barang']);
      
      if ($dibelakang_koma == ",000") {
          $jumlah_produk_tampil = hapus_koma($row["jumlah_produk"],2);
       }
       else{
          $jumlah_produk_tampil = koma($row["jumlah_produk"],2);
       }

      $total_produk_yg_dibutuhkan = $jumlah_parcel * $row["jumlah_produk"];

      $subtotal_hpp = $total_hpp * $total_produk_yg_dibutuhkan;

      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      $nestedData[] = "<p style='font-size:15px' class='edit-jumlah' data-id='".$row['id']."' data-kode-barang-input='".$row['kode_barang']."'> <span id='text-jumlah-".$row['id']."'>".$jumlah_produk_tampil."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".koma($row['jumlah_produk'],2)."' class='input_jumlah'
      data-id='".$row['id']."' data-stok-tbs='".$total_produk_yg_dibutuhkan."' data-id-produk='".$row['id_produk']."' autofocus='' data-kode='".$row['kode_barang']."' data-satuan='".$row['satuan']."' data-harga='".$row['harga_produk']."' data-nama-barang='".$row['nama_barang']."'> </p>";

      $nestedData[] = gantiKoma($total_produk_yg_dibutuhkan);

      $nestedData[] = '<p style="width:50">'.rp($total_hpp).'</p>';
      $nestedData[] = '<p style="width:50">'.rp($subtotal_hpp).'</p>';

      $nestedData[] = $row["nama"];

      $nestedData[] = "<button class='btn btn-danger btn-sm btn-hapus-tbs' id='hapus-tbs-". $row['id'] ."' data-id='". $row['id'] ."' data-id-produk='". $row['id_produk'] ."' data-kode='". $row['kode_barang'] ."' data-nama='". $row['nama_barang'] ."'> Hapus</button>";

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