<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);

 $query_tbs_penjualan = $db->query("SELECT IFNULL(SUM(subtotal),0) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
 $data_tbs_penjualan  = mysqli_fetch_array($query_tbs_penjualan);


 echo$total_penjualan = $data_tbs_penjualan['total_penjualan'];


?>

