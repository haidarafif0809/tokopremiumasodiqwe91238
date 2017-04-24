<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur_pembayaran = $_GET['no_faktur_pembayaran'];
$no_faktur_penjualan = $_GET['no_faktur_penjualan'];



$perintah3 = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
while ($data = mysqli_fetch_array($perintah))
{


$perintah1 = $db->query("INSERT INTO tbs_pembayaran_piutang (no_faktur_pembayaran, no_faktur_penjualan, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar) VALUES ( '$data[no_faktur_pembayaran]', '$data[no_faktur_penjualan]', now(), '$data[tanggal_jt]', '$data[kredit]', '$data[potongan]', '$data[total]', '$data[jumlah_bayar]')");


}

 header ('location:edit_pembayaran_piutang.php?no_faktur_pembayaran='.$no_faktur_pembayaran.'');

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


