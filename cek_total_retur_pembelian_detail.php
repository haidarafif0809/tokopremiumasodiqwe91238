<?php 
include 'db.php';
include 'sanitasi.php';

$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);


$query02 = $db->query("SELECT SUM(subtotal) AS total_akhir FROM detail_retur_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$row = mysqli_fetch_array($query02);

 echo rp($row['total_akhir']);


 ?>