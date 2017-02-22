<?php

include 'sanitasi.php';
include 'db.php';

$id = stringdoang($_POST['id']);
$harga = angkadoang($_POST['harga']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$subtotal = $harga * $jumlah_baru;




$query = $db->prepare("UPDATE tbs_item_masuk SET jumlah = ?, subtotal = ? WHERE id = ?");

$query->bind_param("iis",
	$jumlah_baru, $subtotal, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo "sukses";
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>