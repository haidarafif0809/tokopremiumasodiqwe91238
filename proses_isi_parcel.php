<?php session_start();
 
//memasukkan file db.php
include 'sanitasi.php';
include 'db.php';
$session_id = stringdoang($_POST['session_id']);
$id_produk = angkadoang($_POST['id_produk']);
$jumlah_barang = angkadoang($_POST['jumlah_barang']);
$kode_parcel = stringdoang($_POST['kode_parcel']);



$perintah = "INSERT INTO tbs_parcel (session_id,kode_parcel,id_produk,jumlah_produk) VALUES ('$session_id','$kode_parcel','$id_produk','$jumlah_barang')";

if ($db->query($perintah) === TRUE) {
	} 

	else {
	echo "Error: " . $perintah . "<br>" . $db->error;
	}

?>