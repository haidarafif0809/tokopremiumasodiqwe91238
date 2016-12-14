<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = $_GET['no_faktur'];
$tanggal = $_GET['tanggal'];

$perintah3 = $db->query("SELECT * FROM tbs_stok_opname WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_stok_opname WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_stok_opname WHERE no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah)){

	$data_satuan = $db->query("SELECT satuan FROM barang WHERE kode_barang = '$data[kode_barang]'");
	$cek = mysqli_fetch_array($data_satuan);

$perintah1 = $db->query("INSERT INTO tbs_stok_opname (no_faktur, kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$cek[satuan]', '$data[awal]', '$data[masuk]', '$data[keluar]', '$data[stok_sekarang]', '$data[fisik]', '$data[selisih_fisik]', '$data[selisih_harga]', '$data[harga]', '$data[hpp]')");


}

 header ('location:edit_form_stok_opname.php?no_faktur='.$no_faktur.'&tanggal='.$tanggal.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


