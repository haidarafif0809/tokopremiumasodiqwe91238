<?php 

//memasukkan file db.php
include 'db.php';

include 'sanitasi.php';

//mengirimkan $id menggunakan metode GET
$id = angkadoang($_POST['id']);
$no_trx = stringdoang($_POST['no_trx']);

//menghapus seluruh data yang ada pada tabel kas berdasarkan id
$query = $db->query("DELETE FROM target_penjualan WHERE id = '$id'");

$query10 = $db->query("DELETE FROM detail_target_penjualan WHERE no_trx = '$no_trx'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>