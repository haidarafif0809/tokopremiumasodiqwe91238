<?php include 'session_login.php';
/* Database connection start */
include 'sanitasi.php';
include 'db.php';

/* Database connection end */

$session_id = session_id();

$pilih_akses_tombol = $db->query("SELECT * FROM otoritas_form_order_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
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

);

// getting total number records without any search
$sql =" SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama,bb.berkaitan_dgn_stok ";
$sql.=" FROM tbs_penjualan_order tp LEFT JOIN satuan s ON tp.satuan = s.id LEFT JOIN barang bb ON tp.kode_barang = bb.kode_barang ";
$sql.=" WHERE tp.session_id = '$session_id' ";

$query = mysqli_query($conn, $sql) or die("eror 1");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql ="SELECT tp.id,tp.kode_barang,tp.satuan,tp.nama_barang,tp.jumlah_barang,tp.harga,tp.subtotal,tp.potongan,tp.tax,s.nama,bb.berkaitan_dgn_stok ";
$sql.=" FROM tbs_penjualan_order tp LEFT JOIN satuan s ON tp.satuan = s.id LEFT JOIN barang bb ON tp.kode_barang = bb.kode_barang ";
$sql.=" WHERE tp.session_id = '$session_id' ";

    $sql.=" AND (tp.kode_barang LIKE '".$requestData['search']['value']."%'";  
    $sql.=" OR tp.nama_barang LIKE '".$requestData['search']['value']."%' ";
    $sql.=" OR s.nama LIKE '".$requestData['search']['value']."%' )";

}


$query=mysqli_query($conn, $sql) or die("eror 2");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 
        
$sql.=" ORDER BY tp.id DESC LIMIT ".$requestData['start']." ,".$requestData['length']."   ";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
$query=mysqli_query($conn, $sql) or die("eror 3");


$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array(); 


      $nestedData[] = $row["kode_barang"];
      $nestedData[] = $row["nama_barang"];

      if ($otoritas_tombol['edit_produk'] > 0){

        $nestedData[] = "<p style='font-size:15px' align='right' class='edit-jumlah' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-berstok = '".$row['berkaitan_dgn_stok']."'  data-harga='".$row['harga']."' data-satuan='".$row['satuan']."' > </p>";

      }
      else{

      $nestedData[] = "<p style='font-size:15px' align='right' class='tidak_punya_otoritas' data-id='".$row['id']."'><span id='text-jumlah-".$row['id']."'>". $row['jumlah_barang'] ."</span> <input type='hidden' id='input-jumlah-".$row['id']."' value='".$row['jumlah_barang']."' class='input_jumlah' data-id='".$row['id']."' autofocus='' data-kode='".$row['kode_barang']."' data-berstok = '".$row['berkaitan_dgn_stok']."'  data-harga='".$row['harga']."' data-satuan='".$row['satuan']."' > </p>";
      }


      $nestedData[] = $row["nama"];

      $nestedData[] = "<p  align='right'>".rp($row["harga"])."</p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-subtotal-".$row['id']."'> ".rp($row["subtotal"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-potongan-".$row['id']."'> ".rp($row["potongan"])." </span> </p>";
      $nestedData[] = "<p style='font-size:15px' align='right'><span id='text-tax-".$row['id']."'> ".rp($row["tax"])." </span> </p>";

if ($otoritas_tombol['hapus_produk'] > 0) {

      $nestedData[] = "<button class='btn btn-danger btn-hapus-tbs btn-sm' id='btn-hapus-".$row['id']."' data-id='". $row['id'] ."' data-kode-barang='". $row['kode_barang'] ."' data-barang='". $row['nama_barang'] ."' data-subtotal='". $row['subtotal'] ."'>Hapus</button>";
}
else{
        $nestedData[] = "<p  style='font-size:15px; color:red'> Tidak Ada Otoritas</p>";
}

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


