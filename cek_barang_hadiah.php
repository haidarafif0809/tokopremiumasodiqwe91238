<?php session_start();
include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_POST['kode_barang']);

$cek = $db->query("SELECT kode_barang FROM master_poin WHERE kode_barang = '$kode_barang' ");
$rows = mysqli_num_rows($cek);

	$cek_poin = $db->query("SELECT quantity_poin FROM master_poin WHERE kode_barang = '$kode_barang' ");
	$poinbarang = mysqli_fetch_array($cek_poin);
	$jumlah_poin = $poinbarang['quantity_poin'];


if ($rows > 0 )
{
	echo $jumlah_poin;
}
else
{
echo 0;
}
//Untuk Memutuskan Koneksi Ke Database
 ?>

