<?php session_start();

include 'db.php';
include 'persediaan.function.php';

 $jumlah_baru = $_POST['jumlah_baru'];
 $kode_barang = $_POST['kode_barang'];

 $stok = cekStokHpp($kode_barang);

 $hasil = $stok - $jumlah_baru;

 if ($hasil < 0) {
 	echo "1";
 }
 else{
 	echo "0";
 }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
?>