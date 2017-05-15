<?php session_start();


include 'sanitasi.php';
include 'db.php';

$jumlah_baru = gantiTitik(stringdoang($_POST['jumlah_baru']));
$harga_produk = stringdoang($_POST['harga_produk']);
$jumlah_lama = stringdoang($_POST['jumlah_lama']);
$id = stringdoang($_POST['id_produk']);
$kode_parcel = $_POST['kode_parcel'];
$subtotal = $jumlah_baru * $harga_produk;


$query = $db->query("UPDATE tbs_parcel SET jumlah_produk = '$jumlah_baru', subtotal_produk = '$subtotal'  WHERE id_produk = '$id' AND kode_parcel = '$kode_parcel'");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>
