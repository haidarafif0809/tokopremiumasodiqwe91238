<?php 
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

//mengirimkan $id menggunakan metode GET

$id = angkadoang($_POST['id']);
$kode_barang = stringdoang($_POST['kode_barang']);

$query2 = $db->query("DELETE FROM master_poin WHERE id = '$id' AND kode_barang = '$kode_barang' ");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
