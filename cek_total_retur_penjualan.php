<?php session_start();


// memasukan file db.php
include 'db.php';


$session_id = session_id();


 $query = $db->query("SELECT SUM(subtotal) AS total_retur_pembelian FROM tbs_retur_penjualan WHERE session_id = '$session_id'");
 
 // menyimpan data sementara pada $query
 $data = mysqli_fetch_array($query);

// menampilkan file atau isi dari data total pembelian
 echo $data['total_retur_pembelian'] ;

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
        
  ?>


