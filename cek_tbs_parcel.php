<?php 

include 'db.php';

$session_id = session_id();
$id_produk = $_POST['id_produk'];
$kode_parcel = $_POST['kode_parcel'];

$query = $db->query("SELECT * FROM tbs_parcel WHERE id_produk = '$id_produk' AND kode_parcel = '$kode_parcel' ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db); 

 ?>