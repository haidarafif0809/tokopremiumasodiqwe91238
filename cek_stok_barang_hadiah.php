<?php session_start();

include 'db.php';
include 'sanitasi.php';

$kode_barang = stringdoang($_POST['kode_barang']);


        $select1 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_masuk FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
        $masuk = mysqli_fetch_array($select1);

        $select2 = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_keluar FROM hpp_keluar WHERE kode_barang = '$kode_barang'");
        $keluar = mysqli_fetch_array($select2);

       echo $stok_barang = $masuk['jumlah_masuk'] - $keluar['jumlah_keluar'];

 
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
