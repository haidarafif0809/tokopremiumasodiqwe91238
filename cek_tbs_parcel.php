<?php 

include 'db.php';

$id_produk = $_POST['id_produk'];
$id_parcel = $_POST['id_parcel'];

$query = $db->query("SELECT * FROM detail_perakitan_parcel WHERE id_produk = '$id_produk' AND id_parcel = '$id_parcel' ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db); 

 ?>