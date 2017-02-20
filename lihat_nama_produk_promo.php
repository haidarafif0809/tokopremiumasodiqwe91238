<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_produk = stringdoang($_GET['kode_produk']);


$result = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_produk'");
$row = mysqli_fetch_array($result);
   
    echo json_encode($row);
    exit;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>