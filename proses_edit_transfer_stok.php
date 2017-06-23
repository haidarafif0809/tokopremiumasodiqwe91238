<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = stringdoang($_GET['no_faktur']);

$perintah3 = $db->query("SELECT no_faktur FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_transfer_stok WHERE no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah)){

	$perintah1 = $db->query("INSERT INTO tbs_transfer_stok(no_faktur, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, tanggal, jam) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$data[kode_barang_tujuan]', '$data[nama_barang_tujuan]', '$data[jumlah]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[tanggal]', '$data[jam]')");


}

 header ('location:edit_transfer_stok.php?no_faktur='.$no_faktur.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


