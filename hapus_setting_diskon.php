<?php 
//memasukan file db.php
include 'sanitasi.php';
include 'db.php';

//mengirimkan $id menggunakan metode GET

$id = angkadoang($_POST['id']);

$query2 = $db->query("DELETE FROM setting_diskon_jumlah WHERE id = '$id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
