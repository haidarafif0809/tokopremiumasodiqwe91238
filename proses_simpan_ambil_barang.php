<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];

$select_order = $db->query("SELECT no_faktur_order FROM tbs_penjualan WHERE no_faktur = '$no_faktur'  ");
while($sq = mysqli_fetch_array($select_order))
{
	$update_order = $db->query("UPDATE penjualan_order SET status_order = 'Sedang Order' WHERE no_faktur_order = '$sq[no_faktur_order]' ");
}

$delete = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur' ");
$delete_fee = $db->query("DELETE FROM tbs_fee_produk WHERE no_faktur = '$no_faktur' ");

$select_fee = $db->query("SELECT * FROM laporan_fee_produk WHERE no_faktur = '$no_faktur'");
while($out_fee = mysqli_fetch_array($select_fee))
{

	$insert_fee = $db->query("INSERT INTO tbs_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam) VALUES ('$out_fee[nama_petugas]','$out_fee[no_faktur]','$out_fee[kode_produk]','$out_fee[nama_produk]','$out_fee[jumlah_fee]','$out_fee[tanggal]',
		'$out_fee[jam]')");

}

$select = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
while($out = mysqli_fetch_array($select))
{

	$insert = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp, tanggal, jam) VALUES 
		('$out[no_faktur]','$out[kode_barang]','$out[nama_barang]','$out[jumlah_barang]',
		'$out[satuan]','$out[harga]','$out[subtotal]','$out[potongan]','$out[tax]','$out[hpp]',
		'$out[tanggal]','$out[jam]') ");


}



 ?>