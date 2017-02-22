<?php 


// memasukan file db.php
include 'db.php';


 // mengirim data no faktur menggunakan metode POST

 $no_faktur = $_POST['no_faktur'];
 

 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query2 = $db->query("SELECT subtotal AS total_pembelian FROM detail_pembelian WHERE no_faktur = '$no_faktur'");
 $data = mysqli_fetch_array($query2);
 $total = $data['total_pembelian'];

 $query1 = $db->query("SELECT sisa AS total_pembelian FROM pembelian WHERE no_faktur = '$no_faktur'");
 $data1 = mysqli_fetch_array($query1);
 $sisa = $data1['total_pembelian'];
// menampilkan file atau isi dari data total pembelian

 echo $pembayaran_pembelian =  $total + $sisa 

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


