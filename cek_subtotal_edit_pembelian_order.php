<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';
session_start();

// mengirim data no faktur menggunakan metode POST
 $no_faktur = stringdoang($_POST['no_faktur']);
 $subtotal_tampil = angkadoang($_POST['total2']);

 $query = $db->query("SELECT SUM(subtotal) AS total_pembelian FROM tbs_pembelian_order WHERE no_faktur_order = '$no_faktur'");
 $data = mysqli_fetch_array($query);
 $total = $data['total_pembelian'];

if ($subtotal_tampil != $total) {
		echo 1;
	}
	else{
		echo 2;
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>