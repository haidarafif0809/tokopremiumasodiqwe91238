<?php 

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';


$perintah = $db->prepare("INSERT INTO satuan_konversi (kode_barcode,id_satuan,id_produk,kode_produk,konversi,harga_pokok,harga_jual_konversi)
			VALUES (?,?,?,?,?,?,?)");

$perintah->bind_param("ssissii",
	$barcode,$nama_satuan_konversi, $id_produk, $kode_produk, $konversi, $harga_pokok, $harga_jual_konversi);

	$nama_satuan_konversi = stringdoang($_POST['nama_satuan_konversi']);
  $barcode = stringdoang($_POST['barcode']);
	$id_produk = angkadoang($_POST['id_produk']);
	$konversi = stringdoang($_POST['konversi']);
  $harga_pokok = angkadoang($_POST['harga_pokok']);
  $harga_jual_konversi = angkadoang($_POST['harga_jual_konversi']);
	$kode_produk = stringdoang($_POST['kode_produk']);

$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}



 ?>

