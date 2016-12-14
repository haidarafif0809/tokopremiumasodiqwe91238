<?php 

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = $_POST['session_id'];
 

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);

// menampilkan dsata atau isi pada total penjualan
 $total = $data['total_penjualan'] ;

 $a =  intval($total);

echo rp($a);

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


