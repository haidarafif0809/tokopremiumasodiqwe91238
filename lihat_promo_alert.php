<?php 
include 'db.php';
include 'sanitasi.php';

header('Content-Type: application/json');

$id_produk = stringdoang($_POST['id_barang']);


$query = $db->query("SELECT pesan_alert FROM promo_alert WHERE id_produk = '$id_produk' AND status = '1' ");
$data = mysqli_fetch_array($query);
$promo = $data['pesan_alert'];

 $promo = json_encode($promo);

echo '{ "promo": '.$promo.'}';




?>