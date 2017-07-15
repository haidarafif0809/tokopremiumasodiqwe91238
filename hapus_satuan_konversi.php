<?php 
//memasukan file db.php
include 'sanitasi.php';
include 'db.php';

//mengirimkan $id menggunakan metode GET

$id = stringdoang($_POST['id']);

$query2 = $db->query("DELETE FROM satuan_konversi WHERE id = '$id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
