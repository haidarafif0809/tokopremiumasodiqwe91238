<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = session_id();


$no_faktur = stringdoang($_POST['no_faktur']);
$no_fakt = stringdoang($_POST['no_fakt']);



$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur' AND no_faktur = '$no_fakt' ");


$update_status_order = $db->query("UPDATE penjualan_order SET status_order = 'Sedang Order' WHERE no_faktur_order = '$no_faktur' ");

$update_status_order = $db->query("UPDATE tbs_fee_produk SET session_id = '' WHERE no_faktur_order = '$no_faktur' ");

//Untuk Memutuskan Koneksi Ke Database
 ?>

