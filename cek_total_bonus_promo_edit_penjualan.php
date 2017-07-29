<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);

//cek ada tidaknya program disc di tbs bonus penjualan == DISC PRODUK
$query_tbs_bonus_penjualan = $db->query("SELECT SUM(subtotal) AS subtotal_disc FROM tbs_bonus_penjualan WHERE no_faktur_penjualan = '$no_faktur' AND keterangan = 'Disc Produk'");
	$data_tbs_bonus_penjualan = mysqli_fetch_array($query_tbs_bonus_penjualan);
	$jumlah_data_tbs_penjualan = mysqli_num_rows($query_tbs_bonus_penjualan);
	$subtotal_disc = $data_tbs_bonus_penjualan['subtotal_disc'];
if ($jumlah_data_tbs_penjualan > 0) {
	 echo json_encode($subtotal_disc);
}
else{
	echo 0;
}

?>