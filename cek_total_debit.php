<?php 


// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


 // mengirim data no faktur menggunakan metode POST
 $session_id = $_POST['session_id'];

 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query = $db->query("SELECT SUM(debit) AS t_debit FROM tbs_jurnal WHERE session_id = '$session_id'");
 
 // menyimpan data sementara pada $query
 $data = mysqli_fetch_array($query);

// menampilkan file atau isi dari data total pembelian
 echo koma($data['t_debit'],2);

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


