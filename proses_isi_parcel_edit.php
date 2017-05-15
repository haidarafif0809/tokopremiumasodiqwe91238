<?php session_start();
 
//memasukkan file db.php
include 'sanitasi.php';
include 'db.php';
$no_faktur = stringdoang($_POST['no_faktur']);
$id_produk = angkadoang($_POST['id_produk']);
$jumlah_barang = stringdoang($_POST['jumlah_barang']);
$kode_parcel = stringdoang($_POST['kode_parcel']);
$harga_produk = stringdoang($_POST['harga_produk']);
$subtotal_produk = $harga_produk * $jumlah_barang;



$perintah = "INSERT INTO tbs_parcel (no_faktur,kode_parcel,id_produk,jumlah_produk,harga_produk,subtotal_produk) VALUES ('$no_faktur','$kode_parcel','$id_produk','$jumlah_barang','$harga_produk','$subtotal_produk')";

if ($db->query($perintah) === TRUE) {
	} 

	else {
	echo "Error: " . $perintah . "<br>" . $db->error;
	}

?>