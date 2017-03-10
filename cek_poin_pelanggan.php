<?php 
include 'sanitasi.php';
include 'db.php';

$pelanggan = angkadoang($_POST['pelanggan']);



    $poin_masuk = $db->query("SELECT SUM(poin) AS total_poin FROM poin_masuk WHERE id_pelanggan = '$pelanggan'");
    $masuk = mysqli_fetch_array($poin_masuk);

    $poin_keluar = $db->query("SELECT SUM(subtotal_poin) AS total_poin FROM poin_keluar WHERE id_pelanggan = '$pelanggan'");
    $keluar = mysqli_fetch_array($poin_keluar);

    echo$total_poin = $masuk['total_poin'] - $keluar['total_poin'];


 ?>

  