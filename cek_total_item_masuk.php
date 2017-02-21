<?php session_start();

// memasukan file db.php
include 'db.php';

// mengirim data no faktur menggunakan metode POST
 $session_id = session_id();
 

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_item_masuk FROM tbs_item_masuk WHERE session_id = '$session_id'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);

// menampilkan dsata atau isi pada total penjualan
 echo $data['total_item_masuk'] ;

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

  ?>


