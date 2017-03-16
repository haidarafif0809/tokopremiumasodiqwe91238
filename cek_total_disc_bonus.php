<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = $_GET['tanggal_sekarang'];

$tb = $db->query("SELECT sum(harga_disc) as harga FROM tbs_bonus_penjualan WHERE tanggal = '$tanggal_sekarang' AND keterangan = 'Disc Produk'");
$tbse = mysqli_fetch_array($tb);


  echo json_encode($tbse);



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


