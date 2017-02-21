<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = $_GET['no_faktur'];
$nama_daftar_akun = $_GET['nama_daftar_akun'];



$perintah3 = $db->query("SELECT * FROM tbs_kas_masuk WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_kas_masuk WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_kas_masuk WHERE no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah))
{


$perintah1 = $db->query("INSERT INTO tbs_kas_masuk (no_faktur, keterangan, dari_akun, ke_akun, jumlah, tanggal, jam, user) VALUES ('$data[no_faktur]', '$data[keterangan]', '$data[dari_akun]', '$data[ke_akun]', '$data[jumlah]', now(), now(), '$data[user]')");


}

 header ('location:edit_data_kas_masuk.php?no_faktur='.$no_faktur.'&nama_daftar_akun='.$nama_daftar_akun.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


