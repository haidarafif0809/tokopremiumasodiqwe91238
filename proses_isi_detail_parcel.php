<?php session_start();
 
//memasukkan file db.php
include 'sanitasi.php';
include 'db.php';

$perintah = $db->prepare("INSERT INTO detail_perakitan_parcel (id_parcel,id_produk,jumlah_produk) VALUES (?,?,?)");

$perintah->bind_param("iii",
$id_parcel, $id_produk, $jumlah_barang);

$id_produk = angkadoang($_POST['id_produk']);
$jumlah_barang = angkadoang($_POST['jumlah_barang']);
$id_parcel = angkadoang($_POST['id_parcel']);
        
$perintah->execute();

if (!$perintah) {
die('Query Error : '.$db->errno.
' - '.$db->error);
}
else {

}


?>