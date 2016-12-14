<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_barang = stringdoang($_GET['kode_barang']);
 
    //ambil data barang

$result = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");
$row = mysqli_fetch_array($result);
   
    echo json_encode($row);
    exit;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>