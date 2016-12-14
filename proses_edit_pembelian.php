<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = $_GET['no_faktur'];
$suplier = $_GET['suplier'];
$nama_suplier = $_GET['nama_suplier'];
$kode_gudang = $_GET['kode_gudang'];
$nama_gudang = $_GET['nama_gudang'];

$perintah3 = $db->query("SELECT * FROM tbs_pembelian WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_pembelian WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_pembelian WHERE no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah)){


if ($data['satuan'] == $data['asal_satuan']) {
	

$perintah1 = $db->query("INSERT INTO tbs_pembelian (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah_barang]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]')");
}

else{



$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
$data_konversi = mysqli_fetch_array($konversi);

$jumlah_produk = $data['jumlah_barang'] / $data_konversi['konversi'];
$harga_produk = $data_konversi['harga_pokok'];


$perintah1 = $db->query("INSERT INTO tbs_pembelian (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_produk', '$data[satuan]', '$harga_produk', '$data[subtotal]', '$data[potongan]', '$data[tax]')");

}



}

 header ('location:coba.php?no_faktur='.$no_faktur.'&suplier='.$suplier.'&nama_suplier='.$nama_suplier.'&kode_gudang='.$kode_gudang.'&nama_gudang='.$nama_gudang.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


