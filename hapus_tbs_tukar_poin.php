<?php 

//memasukan file db.php
include 'sanitasi.php';
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = stringdoang($_POST['id']);

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_tukar_poin WHERE id = '$id'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
