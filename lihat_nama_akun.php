<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_akun = stringdoang($_GET['kode_akun']);


$result = $db->query("SELECT nama_daftar_akun FROM daftar_akun WHERE kode_daftar_akun = '$kode_akun'");
$row = mysqli_fetch_array($result);
   
    echo json_encode($row);
    exit;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>