<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();

// menampilakn data dan cek ada tidaknya program disc di tbs bonus penjualan == DISC PRODUK
 $query_tbs_bonus_disc = $db->query("SELECT kode_produk,SUM(qty_bonus) AS qty_disc,harga_disc,keterangan FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Disc Produk'");
 $jumlah_data_tbs_bonus_disc = mysqli_num_rows($query_tbs_bonus_disc);
 $data_tbs_bonus_disc = mysqli_fetch_array($query_tbs_bonus_disc);

// menampilakn data dan cek ada tidaknya program di tbs bonus penjualan == FREE PRODUK
 $query_tbs_bonus_free = $db->query("SELECT kode_produk,SUM(qty_bonus) AS qty_free,keterangan FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Free Produk'");
 $data_tbs_bonus_free = mysqli_fetch_array($query_tbs_bonus_free);
 $jumlah_data_tbs_bonus_free = mysqli_num_rows($query_tbs_bonus_free);

if ($jumlah_data_tbs_bonus_disc > 0) {
	 echo json_encode($data_tbs_bonus_disc);
}
else if ($jumlah_data_tbs_bonus_free > 0) {
	echo json_encode($data_tbs_bonus_free);
}
else{
	echo 0;
}

?>