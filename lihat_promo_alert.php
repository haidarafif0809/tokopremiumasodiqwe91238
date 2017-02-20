<?php 
include 'db.php';
include 'sanitasi.php';

$id_produk = stringdoang($_POST['id']);


$query = $db->query("SELECT pesan_alert FROM promo_alert WHERE id_produk = '$id_produk' AND status = '1' ");
$data = mysqli_fetch_array($query);
	echo $layanan = $data['pesan_alert'];



?>