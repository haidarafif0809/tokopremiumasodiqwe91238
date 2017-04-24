<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();

//cek ada tidaknya program disc di tbs bonus penjualan == DISC PRODUK
$querycek = $db->query("SELECT kode_produk FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Disc Produk'");
 $cek = mysqli_num_rows($querycek);

// menampilakn data bonus penjualan == DISC PRODUK
 $query = $db->query("SELECT SUM(qty_bonus) AS qty_disc,harga_disc,keterangan FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Disc Produk'");
 $data = mysqli_fetch_array($query);

//cek ada tidaknya program free di tbs bonus penjualan == FREE PRODUK
$queryfree = $db->query("SELECT kode_produk FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Free Produk'");
 $free = mysqli_num_rows($queryfree);

// menampilakn data bonus penjualan == FREE PRODUK
 $querybonus = $db->query("SELECT SUM(qty_bonus) AS qty_free,keterangan FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Free Produk'");
 $databonus = mysqli_fetch_array($querybonus);

if ($cek > 0) {
	 echo json_encode($data);
}
else if ($free > 0) {
	echo json_encode($databonus);
}
else{
	echo 0;
}

?>