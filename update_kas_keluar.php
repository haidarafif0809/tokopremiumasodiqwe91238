<?php
include 'sanitasi.php';
include 'db.php';



$query1 = $db->prepare("UPDATE kas SET jumlah = jumlah + ? WHERE nama = ?");

$query1->bind_param("is",
	$jumlah, $dari_akun);

$jumlah = angkadoang($_POST['jumlah']);
$dari_akun = stringdoang($_POST['dari_akun']);

$query1->execute();


$query2 = $db->prepare("UPDATE kas SET jumlah = jumlah - ? WHERE nama = ?");

$query2->bind_param("is",
	$jumlah_baru, $dari_akun);

$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$dari_akun = stringdoang($_POST['dari_akun']);

$query2->execute();


$query = $db->prepare("UPDATE kas_keluar SET jumlah = ? WHERE id = ?");

$query->bind_param("is",
	$jumlah_baru, $id);


$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$id = stringdoang($_POST['id']);


$query->execute();

$query00 = $db->prepare("UPDATE detail_kas_keluar SET jumlah = ? WHERE id = ?");
$query00->bind_param("is",
    $jumlah_baru, $id);

$jumlah_baru = angkadoang($_POST['jumlah_baru']);

$query00->execute();



    if (!$query1) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    header('location:kas_keluar.php');
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>