<?php session_start();
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$kode_parcel = stringdoang($_POST['kode_parcel']);
$jumlah_parcel = stringdoang($_POST['jumlah_parcel']);
$estimasi_hpp = 0;

$query_tbs = $db->query("SELECT tp.kode_parcel, b.kode_barang, tp.jumlah_produk FROM tbs_parcel tp INNER JOIN barang b ON tp.id_produk = b.id WHERE tp.kode_parcel = '$kode_parcel'");
while ($data_tbs = mysqli_fetch_array($query_tbs)) {
	   
	   $total_hpp = hitungHppProduk($data_tbs['kode_barang']);
	   $total_produk_yg_dibutuhkan = $jumlah_parcel * $data_tbs["jumlah_produk"];
	   $subtotal_hpp = $total_hpp * $total_produk_yg_dibutuhkan; 
	   $estimasi_hpp = $estimasi_hpp + $subtotal_hpp;
}

if ($jumlah_parcel == 0) {
	$nilai_estimasi = 0;
}
else{
	$nilai_estimasi = $estimasi_hpp / $jumlah_parcel;
}

echo round($nilai_estimasi);
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);
        
?>