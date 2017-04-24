<?php
include 'sanitasi.php';
include 'db.php';





$query1 = $db->prepare("UPDATE barang SET jumlah_barang = jumlah_barang - ? WHERE kode_barang = ?");

$query1->bind_param("is",
	$jumlah, $kode_barang);

	$jumlah = angkadoang($_POST['jumlah']);
	$kode_barang = stringdoang($_POST['kode_barang']);
	

$query1->execute();


$query2 = $db->prepare("UPDATE barang SET jumlah_barang = jumlah_barang + ? WHERE kode_barang = ?");

$query2->bind_param("is",
	$jumlah_baru, $kode_barang);

	
	$kode_barang = stringdoang($_POST['kode_barang']);

$query2->execute();


$query = $db->prepare("UPDATE detail_item_masuk SET jumlah = ? WHERE no_faktur = ? AND kode_barang = ?");

$query->bind_param("iss",
	$jumlah_baru, $no_faktur, $kode_barang);
	
	$jumlah_baru = angkadoang($_POST['jumlah_baru']);
	$no_faktur = stringdoang($_POST['no_faktur']);
	$kode_barang = stringdoang($_POST['kode_barang']);

$query->execute();



    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    header('location:user.php');
    }

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
 
