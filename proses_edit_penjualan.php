<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = $_GET['no_faktur'];
$kode_pelanggan = $_GET['kode_pelanggan'];
$nama_gudang = $_GET['nama_gudang'];
$kode_gudang = $_GET['kode_gudang'];

$perintah3 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah)){

if ($data['satuan'] == $data['asal_satuan']) {

$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah_barang]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[hpp]')");

}

else{

$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
$data_konversi = mysqli_fetch_array($konversi);

$jumlah_produk = $data['jumlah_barang'] / $data_konversi['konversi'];
$harga = $data['harga'] * $data['jumlah_barang'];

$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_produk', '$data[satuan]', '$harga', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[hpp]')");

}



}

 header ('location:edit_penjualan.php?no_faktur='.$no_faktur.'&kode_pelanggan='.$kode_pelanggan.'&nama_gudang='.$nama_gudang.'&kode_gudang='.$kode_gudang.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


