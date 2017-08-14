<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


// mengirim data no faktur menggunakan metode POST
$session_id = session_id();

 $query_bonus_penjualan = $db->query("SELECT SUM(subtotal) AS total_diskon FROM tbs_bonus_penjualan WHERE session_id = '$session_id' AND keterangan = 'Diskon'");
 $data_bonus = mysqli_fetch_array($query_bonus_penjualan);
echo $total_diskon = $data_bonus['total_diskon'];




//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>

