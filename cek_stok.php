<?php 

include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$kode_barang = stringdoang($_POST['kode_barang']);

echo $stok_barang = cekStokHpp($kode_barang);


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>