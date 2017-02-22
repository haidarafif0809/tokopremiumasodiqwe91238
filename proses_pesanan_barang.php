<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = stringdoang($_GET['no_faktur']);
$kode_pelanggan = stringdoang($_GET['kode_pelanggan']);
$nama_gudang = stringdoang($_GET['nama_gudang']);
$kode_gudang = stringdoang($_GET['kode_gudang']);
$nama_pelanggan = stringdoang($_GET['nama_pelanggan']);

$perintah3 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah)){

$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah_barang]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[hpp]')");


}

 header ('location:bayar_pesanan_barang.php?no_faktur='.$no_faktur.'&kode_pelanggan='.$kode_pelanggan.'&nama_pelanggan='.$nama_pelanggan.'&nama_gudang='.$nama_gudang.'&kode_gudang='.$kode_gudang.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>


