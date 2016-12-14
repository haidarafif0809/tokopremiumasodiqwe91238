<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';
session_start();

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 $subtotal_tampil = angkadoang($_POST['total2']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id'");
 $data = mysqli_fetch_array($query);
 $total = $data['total_penjualan'];

if ($subtotal_tampil == $total) {
		echo "Oke";
	}
	else{
		echo "Zonk";
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>