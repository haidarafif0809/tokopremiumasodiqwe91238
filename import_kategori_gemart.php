<?php 

include 'db.php';

$kategori_gemart = $db->query("SELECT bar_code, category FROM kategori_gemart");
while ($data_gemart = mysqli_fetch_array($kategori_gemart)){

	$update_kategori = $db->query("UPDATE barang SET kategori = '$data_gemart[category]' WHERE kode_barang = '$data_gemart[bar_code]'");

}


 ?>