<?php 


// memasukan file db.php
include 'db.php';


 // mengirim data no faktur menggunakan metode POST
 $no_faktur = $_POST['no_faktur_retur'];


 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_retur_penjualan FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
 
 // menyimpan data sementara pada $query
 $data = mysqli_fetch_array($query);

// menampilkan file atau isi dari data total pembelian
 echo $data['total_retur_penjualan'];

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
  ?>


