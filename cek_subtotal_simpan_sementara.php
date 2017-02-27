<?php 
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

 $no_faktur = angkadoang($_POST['no_faktur']);
// mengirim data no faktur menggunakan metode POST
 $subtotal_tampil = angkadoang($_POST['total2']);


// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
 $data = mysqli_fetch_array($query);
$total = $data['total_penjualan'];

if ($subtotal_tampil != $total) {
		echo "1";
	}
else{
		echo "0";
		
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>

