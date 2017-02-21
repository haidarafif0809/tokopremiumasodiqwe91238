<?php 


// memasukan file db.php
include 'db.php';


 // mengirim data no faktur menggunakan metode POST
 $no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];


 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query = $db->query("SELECT SUM(jumlah_bayar) AS totalbayar FROM tbs_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
 
 // menyimpan data sementara pada $query
 $data = mysqli_fetch_array($query);

// menampilkan file atau isi dari data total pembelian
 echo $data['totalbayar'];

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


