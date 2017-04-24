<?php 
include 'db.php';
include 'sanitasi.php';

$select = $db->query("SELECT id, nama_barang FROM barang");
while ($data = mysqli_fetch_array($select)) {
	$id = $data['id'];
	echo $nama_barang = stringdoang($data['nama_barang']); echo"<br>";

	$update = $db->query("UPDATE barang SET nama_barang = '$nama_barang' WHERE id = '$id'");
}

 ?>