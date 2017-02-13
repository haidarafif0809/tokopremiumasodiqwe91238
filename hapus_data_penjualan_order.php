<?php session_start();

// memsukan file db,php
include 'db.php';


$id = $_POST['id'];
$no_faktur = $_POST['no_faktur'];
$user =  $_SESSION['user_name'];

// INSERT HISTORY PENJUALAN
$penjualan = $db->query("SELECT * FROM penjualan_order WHERE no_faktur_order = '$no_faktur'");
$data_penjualan = mysqli_fetch_array($penjualan);


$insert_penjualan22 = $db->query("INSERT INTO history_penjualan_order (no_faktur_order, kode_gudang, kode_pelanggan, total, tanggal, jam, user, status_order,keterangan) VALUES ('$no_faktur','$data_penjualan[kode_gudang]', '$data_penjualan[kode_pelanggan]', '$data_penjualan[total]','$data_penjualan[tanggal]','$data_penjualan[jam]','$data_penjualan[user]','$data_penjualan[status_order]','$data_penjualan[keterangan]')");


// INSERT HISTORY DETAIL PENJUALAN
$detail_penjualan = $db->query("SELECT * FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur'");
while($data_detail_penjualan = mysqli_fetch_array($detail_penjualan)){

	$insert_penjualan33 = $db->query("INSERT INTO history_detail_penjualan_order (no_faktur_order,kode_barang, nama_barang, jumlah_barang,satuan, harga, subtotal, potongan, tax,tanggal,jam,asal_satuan) VALUES ('$no_faktur', '$data_detail_penjualan[kode_barang]', '$data_detail_penjualan[nama_barang]', '$data_detail_penjualan[jumlah_barang]', '$data_detail_penjualan[satuan]', '$data_detail_penjualan[harga]', '$data_detail_penjualan[subtotal]', '$data_detail_penjualan[potongan]', '$data_detail_penjualan[tax]', '$data_detail_penjualan[tanggal]', '$data_detail_penjualan[jam]', '$data_detail_penjualan[asal_satuan]')");

}



$query3 = $db->query("DELETE FROM tbs_fee_produk WHERE no_faktur = '$no_faktur'");
$query5 = $db->query("DELETE FROM tbs_penjualan_order WHERE no_faktur_order = '$no_faktur'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
