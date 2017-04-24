<?php 
include 'db.php';

$query = $db->query("SELECT * FROM penjualan");
$data = mysqli_num_rows($query);
echo $data;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>