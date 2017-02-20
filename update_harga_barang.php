<?php 

include 'db.php';

$kode_barang = $_POST['kode_barang'];

$query = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$kode_barang'");


	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>