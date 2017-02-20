<?php 
include 'db.php';
include 'sanitasi.php';

$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);


$select = $db->query("SELECT SUM(total) AS totali FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
$row = mysqli_fetch_array($select);

 echo rp($row['totali']);


 ?>