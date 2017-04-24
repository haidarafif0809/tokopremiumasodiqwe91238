<?php 


// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


 // mengirim data no faktur menggunakan metode POST
 $no_faktur = stringdoang($_POST['no_faktur']);

 
 // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
 // berdasarkan no faktur
 $query = $db->query("SELECT SUM(kredit) AS t_kredit FROM tbs_jurnal WHERE no_faktur = '$no_faktur'");
 
 // menyimpan data sementara pada $query
 $data = mysqli_fetch_array($query);

// menampilkan file atau isi dari data total pembelian
 echo $data['t_kredit'] ;

         //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
  ?>


