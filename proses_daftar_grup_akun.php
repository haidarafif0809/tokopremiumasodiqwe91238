<?php session_start();

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

$waktu = date('Y-m-d H:i:sa' );


// menambah data yang ada pada tabel satuan berdasarka id dan nama
$perintah = $db->prepare("INSERT INTO grup_akun (kode_grup_akun,nama_grup_akun,parent,kategori_akun,tipe_akun,user_buat,waktu) VALUES (?,?,?,?,?,?,?)");

$perintah->bind_param("sssssss",
	$kode_akun, $nama_akun, $sub_dari,$kategori_akun,$tipe_akun,$user,$waktu);

	$nama_akun = stringdoang($_POST['nama_akun']);
	$kode_akun = stringdoang($_POST['kode_akun']);
	$sub_dari = stringdoang($_POST['sub_dari']);
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
 header('location:daftar_group_akun.php');
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>