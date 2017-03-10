<?php session_start();
include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_POST['kode_barang']);


	$cek_poin = $db->query("SELECT quantity_poin FROM master_poin WHERE kode_barang = '$kode_barang' ");
	$poinbarang = mysqli_fetch_array($cek_poin);
	$jumlah_poin = $poinbarang['quantity_poin'];


	echo $jumlah_poin;

//Untuk Memutuskan Koneksi Ke Database
 ?>

