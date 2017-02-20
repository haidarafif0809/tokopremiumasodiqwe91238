<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();
$no_faktur = stringdoang($_POST['no_faktur']);

// mengirim data no faktur menggunakan metode POST



// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan_order WHERE no_faktur_order = '$no_faktur'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);
 $total = $data['total_penjualan'];


$a =  intval($total);

echo rp($a);

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        


  ?>
