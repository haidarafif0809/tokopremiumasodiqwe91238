<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 	
 if (isset($_POST['no_faktur'])) {
 	
 	$no_faktur = stringdoang($_POST['no_faktur']);

 	// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 	$query = $db->query("SELECT SUM(subtotal) AS total_transfer FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur' AND (session_id IS NULL OR session_id = '') ");
 
 }
 else{
 	// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 	$query = $db->query("SELECT SUM(subtotal) AS total_transfer FROM tbs_transfer_stok WHERE session_id = '$session_id' AND (no_faktur IS NULL OR no_faktur = '') ");
 
 }


 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);

// menampilkan dsata atau isi pada total penjualan
 echo $data['total_transfer'] ;

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

  ?>


