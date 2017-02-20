<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();
$hapus_order = stringdoang($_POST['hapus_order']);


// mengirim data no faktur menggunakan metode POST



// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(total) AS total_penjualan FROM penjualan_order WHERE no_faktur_order = '$hapus_order'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);
 echo $total = $data['total_penjualan'];


        //Untuk Memutuskan Koneksi Ke Database    
  ?>