<?php 
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_POST['id']);

$query = $db->query("DELETE FROM tbs_pembelian_order WHERE id = '$id'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>