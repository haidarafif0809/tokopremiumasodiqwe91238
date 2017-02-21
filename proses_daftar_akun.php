<?php session_start();

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

$waktu = date('Y-m-d H:i:sa' );


// menambah data yang ada pada tabel satuan berdasarka id dan nama
$perintah = $db->prepare("INSERT INTO daftar_akun (kode_daftar_akun,nama_daftar_akun,grup_akun,kategori_akun,tipe_akun,user_buat,waktu) VALUES (?,?,?,?,?,?,?)");

$perintah->bind_param("sssssss",
	$kode_akun, $nama_akun, $grup_akun,$kategori_akun,$tipe_akun,$user,$waktu);

	$nama_akun = stringdoang($_POST['nama_akun']);
	$kode_akun = stringdoang($_POST['kode_akun']);
	$grup_akun = stringdoang($_POST['grup_akun']);
	$kategori_akun = stringdoang($_POST['kategori_akun']);
	$tipe_akun = stringdoang($_POST['tipe_akun']);
    $user = $_SESSION['nama'];

$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
 header('location:daftar_akun.php?kategori=semua');
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>