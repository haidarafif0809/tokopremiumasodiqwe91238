<?php 

include 'db.php';
include 'sanitasi.php';

$kode_pelanggan =  stringdoang($_POST['kode_pelanggan']);

$query = $db->query("SELECT level_harga FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
$level_harga = mysqli_fetch_array($query);

echo $a = $level_harga['level_harga'];


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
 ?>

