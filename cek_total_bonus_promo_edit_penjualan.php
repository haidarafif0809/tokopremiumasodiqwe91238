<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);

//cek ada tidaknya program disc di tbs bonus penjualan == DISC PRODUK
$query_tbs_bonus_penjualan = $db->query("SELECT IFNULL(SUM(subtotal),0) AS subtotal_disc FROM tbs_bonus_penjualan WHERE no_faktur_penjualan = '$no_faktur' AND keterangan = 'Disc Produk'");
	$data_tbs_bonus_penjualan = mysqli_fetch_array($query_tbs_bonus_penjualan);


	echo$subtotal_disc = $data_tbs_bonus_penjualan['subtotal_disc'];


?>