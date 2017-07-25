<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);

 $query_tbs_penjualan = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
 $jumlah_data_tbs_penjualan = mysqli_num_rows($query_tbs_penjualan);
 $data_tbs_penjualan  = mysqli_fetch_array($query_tbs_penjualan);
 $total_penjualan = $data_tbs_penjualan['total_penjualan'];
 if ($jumlah_data_tbs_penjualan > 0) {
 	echo json_encode($data_tbs_penjualan);
 }
 else{
 	echo 0;
 }


?>

