<?php

include 'db.php';

$id = $_POST['id_produk'];

$query = $db->query("SELECT * FROM produk_promo WHERE nama_produk = '$id'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

