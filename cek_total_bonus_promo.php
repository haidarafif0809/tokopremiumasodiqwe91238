<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();
// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT IFNULL(SUM(qty_bonus),0) AS qty,harga_disc FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Disc Produk'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);
if ($data != '') {
	 echo $total = $data['qty'] * $data['harga_disc'];
}
else{
	echo 0;
}

?>