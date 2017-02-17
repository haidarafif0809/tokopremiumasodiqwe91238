<?php 

include 'db.php';

$id_produk = $_POST['id_produk'];
$session_id = $_POST['session_id'];

$query = $db->query("SELECT * FROM tbs_parcel WHERE id_produk = '$id_produk' AND session_id = '$session_id' ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db); 

 ?>