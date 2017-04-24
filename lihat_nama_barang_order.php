<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_barang = stringdoang($_GET['kode_barang']);



$result = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");
$row = mysqli_fetch_array($result);
   
    echo $row['id'];


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>