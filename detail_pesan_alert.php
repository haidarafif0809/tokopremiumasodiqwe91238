<?php 
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_POST['id']);


$query = $db->query("SELECT * FROM promo_alert WHERE id_promo_alert = '$id' ");
$data = mysqli_fetch_array($query);
echo $layanan = $data['pesan_alert'];
?>