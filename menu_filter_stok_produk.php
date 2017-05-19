<?php 
include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$query_barang = $db->query("SELECT kode_barang, nama_barang FROM barang WHERE berkaitan_dgn_stok = 'Barang' ");
while ($data_barang = mysqli_fetch_array($query_barang)) {
	
	$stok_produk = cekStokHpp($data_barang['kode_barang']);
	$query_update = $db->query("UPDATE barang SET stok_barang = '$stok_produk' WHERE kode_barang = '$data_barang[kode_barang]' ");

}

header('location:filter_stok_produk.php?kategori=semua&tipe=barang');

?>