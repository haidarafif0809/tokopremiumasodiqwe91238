<?php 

include 'sanitasi.php';
include 'db.php';

$kode_meja = $_POST['kode_meja'];
$no_faktur = $_POST['no_faktur'];
$meja_baru = $_POST['meja_baru'];


$update_penjualan = $db->query("UPDATE penjualan SET kode_meja = '$meja_baru' WHERE no_faktur = '$no_faktur'");

$update_detail_penjualan = $db->query("UPDATE detail_penjualan SET kode_meja = '$meja_baru' WHERE no_faktur = '$no_faktur'");

$update_meja = $db->query("UPDATE meja SET status_pakai = 'Belum Terpakai' WHERE kode_meja = '$kode_meja'");

$update_meja0 = $db->query("UPDATE meja SET status_pakai = 'Sudah Terpakai' WHERE kode_meja = '$meja_baru'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>