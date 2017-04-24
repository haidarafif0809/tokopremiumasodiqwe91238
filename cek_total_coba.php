<?php 


// memasukan file db.php
include 'db.php';


 // mengirim data no faktur menggunakan metode POST
 $no_faktur = $_POST['no_faktur'];

 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_pembelian FROM tbs_pembelian WHERE no_faktur = '$no_faktur'");
 
 // menyimpan data sementara pada $query
 $data = mysqli_fetch_array($query);

// menampilkan file atau isi dari data total pembelian
 echo $data['total_pembelian'] ;

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


