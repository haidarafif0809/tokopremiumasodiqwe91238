<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];

//menghapus se+uruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM perakitan_parcel WHERE id = '$id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
