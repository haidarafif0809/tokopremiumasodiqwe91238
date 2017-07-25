<?php session_start();

include 'db.php';
include 'sanitasi.php';

$session_id = session_id();

$query = $db->query("SELECT SUM(subtotal) AS total_order FROM tbs_pembelian_order WHERE session_id = '$session_id'");
$data = mysqli_fetch_array($query);
$total = $data['total_order'];

$total_akhir =  intval($total);

echo rp($total_akhir);
 //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>