<?php 
include 'db.php';

$id = $_POST['id'];

$query = $db->query("DELETE FROM biaya_admin WHERE id = '$id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
