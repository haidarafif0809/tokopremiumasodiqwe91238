<?php session_start();


include 'db.php';
include 'persediaan.function.php';

 $jumlah_baru = $_POST['jumlah_baru'];
 $kode_barang = $_POST['kode_barang'];


$stok = cekStokHpp($kode_barang);





 echo $hasil1 = $stok - $jumlah_baru;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
