<?php 
include 'sanitasi.php';
include 'db.php';

$kode_barang = stringdoang($_POST['kode_barang']);

$cek = $db->query("SELECT * FROM master_poin WHERE kode_barang = '$kode_barang' ");
$rows = mysqli_num_rows($cek);


if ($rows > 0 )
{
	echo 1;
}

//Untuk Memutuskan Koneksi Ke Database
 ?>

