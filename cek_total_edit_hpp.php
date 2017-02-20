<?php 

// memasukan file db.php
include 'db.php';

// mengirim data no faktur menggunakan metode POST
 $no_faktur = $_POST['no_faktur'];
 

// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(hpp) AS total_hpp FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);

// menampilkan dsata atau isi pada total penjualan
 echo $data['total_hpp'] ;

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


