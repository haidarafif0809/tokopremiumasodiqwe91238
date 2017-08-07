<?php 

include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

    $kode_barang = stringdoang($_POST['kode_barang']);
    $ambil_sisa = cekStokHpp($kode_barang);

    echo $ambil_sisa;


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>