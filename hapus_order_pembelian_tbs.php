<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = session_id();


$no_faktur = stringdoang($_POST['no_faktur']);

$perintah2 = $db->query("DELETE FROM tbs_pembelian WHERE no_faktur_order = '$no_faktur'");


$update_status_order = $db->query("UPDATE pembelian_order SET status_order = 'Di Order' WHERE no_faktur_order = '$no_faktur' ");

$update_status_order = $db->query("UPDATE tbs_fee_produk SET session_id = '' WHERE no_faktur_order = '$no_faktur' ");

//Untuk Memutuskan Koneksi Ke Database
 ?>