<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = session_id();


$no_faktur = stringdoang($_GET['no_faktur_order']);


$update_status_order = $db->query("SELECT kode_barang FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur' ");
$san = mysqli_fetch_array($update_status_order);

$update_status_order = $db->query("SELECT * FROM tbs_penjualan WHERE kode_barang = '$san[kode_barang]' ");
$rows = mysqli_num_rows($update_status_order);


if ($rows > 0 )
{
	echo "1";
}
else
{
	echo "0";
}
//Untuk Memutuskan Koneksi Ke Database
 ?>

