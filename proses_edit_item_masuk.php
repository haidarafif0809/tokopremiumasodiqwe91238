<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = $_GET['no_faktur'];

$perintah3 = $db->query("SELECT * FROM tbs_item_masuk WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_item_masuk WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_item_masuk WHERE no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah)){

$perintah1 = $db->query("INSERT INTO tbs_item_masuk (no_faktur, kode_barang, nama_barang, jumlah, satuan, harga, subtotal) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah]', '$data[satuan]', '$data[harga]', '$data[subtotal]')");


}

 header ('location:edit_item_masuk.php?no_faktur='.$no_faktur.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


