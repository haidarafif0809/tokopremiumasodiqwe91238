<?php session_start();

include 'db.php';
include 'sanitasi.php';

$no_faktur_order = stringdoang($_GET['no_faktur']);

$query = $db->query("SELECT SUM(subtotal) AS total_order FROM tbs_pembelian_order WHERE no_faktur_order = '$no_faktur_order'");
$data = mysqli_fetch_array($query);
$total = $data['total_order'];

$total_akhir =  intval($total);

echo rp($total_akhir);
 //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>