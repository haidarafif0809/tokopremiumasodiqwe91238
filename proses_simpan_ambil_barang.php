<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];

$delete = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");

$select = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
while($out = mysqli_fetch_array($select))
{

	$insert = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp, tanggal, jam) VALUES 
		('$out[no_faktur]','$out[kode_barang]','$out[nama_barang]','$out[jumlah_barang]',
		'$out[satuan]','$out[harga]','$out[subtotal]','$out[potongan]','$out[tax]','$out[hpp]',
		'$out[tanggal]','$out[jam]') ");


}


 ?>