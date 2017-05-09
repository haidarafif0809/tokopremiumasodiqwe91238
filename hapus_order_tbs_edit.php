<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = session_id();

$hapus_order = stringdoang($_POST['hapus_order']);
$no_faktur = stringdoang($_POST['no_faktur']);


$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur_order = '$hapus_order'");

$update_status_order = $db->query("UPDATE penjualan_order SET status_order = 'Sedang Order' WHERE no_faktur_order = '$hapus_order' ");

$update_status_order = $db->query("UPDATE tbs_fee_produk SET session_id = '' WHERE no_faktur_order = '$hapus_order' ");

//Untuk Memutuskan Koneksi Ke Database
 ?>



