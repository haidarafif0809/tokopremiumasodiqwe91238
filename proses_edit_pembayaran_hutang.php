<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur_pembayaran = $_GET['no_faktur_pembayaran'];
$no_faktur = $_GET['no_faktur'];
$nama = $_GET['nama'];
$cara_bayar = $_GET['cara_bayar'];



$perintah3 = $db->query("SELECT * FROM tbs_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
while ($data = mysqli_fetch_array($perintah))
{
		$perintah4 = $db->query("SELECT total FROM pembelian WHERE no_faktur = '$no_faktur'");
		$data4 = mysqli_fetch_array($perintah4);
		echo $total = $data4['total'];

$perintah1 = $db->query("INSERT INTO tbs_pembayaran_hutang (no_faktur_pembayaran, no_faktur_pembelian, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar) VALUES ( '$data[no_faktur_pembayaran]', '$data[no_faktur_pembelian]', now(), '$data[tanggal_jt]', '$data[kredit]', '$data[potongan]', '$data[total]', '$data[jumlah_bayar]')");


}

 header ('location:edit_pembayaran_hutang.php?no_faktur_pembayaran='.$no_faktur_pembayaran.'&nama='.$nama.'&cara_bayar='.$cara_bayar.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


