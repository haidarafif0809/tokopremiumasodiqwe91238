<?php session_start();
 
//memasukkan file db.php
include 'sanitasi.php';
include 'db.php';
$session_id = stringdoang($_POST['session_id']);

$q_kode_barang = $db->query("SELECT kode_parcel FROM perakitan_parcel ORDER BY id DESC LIMIT 1");
$v_kode_barang = mysqli_fetch_array($q_kode_barang);
$row_kode_barang = mysqli_num_rows($q_kode_barang);
if ($row_kode_barang = "" || $row_kode_barang = 0) {
	
	echo $kode_produk = "PP1";
}
else{
	$kode_barang_terakhir = $v_kode_barang['kode_parcel'];
	$angka_barang_terakhir = angkadoang($kode_barang_terakhir);
	$kode_produk_sekarang = 1 + $angka_barang_terakhir;
	echo $kode_produk = "PP".$kode_produk_sekarang."";
}

$id_produk = angkadoang($_POST['id_produk']);
$jumlah_barang = angkadoang($_POST['jumlah_barang']);



$perintah = "INSERT INTO tbs_parcel (session_id,kode_parcel,id_produk,jumlah_produk) VALUES ('$session_id','$kode_produk','$id_produk','$jumlah_barang')";

if ($db->query($perintah) === TRUE) {
	} 

	else {
	echo "Error: " . $perintah . "<br>" . $db->error;
	}

?>