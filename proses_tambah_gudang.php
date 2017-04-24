<?php 

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

	//mengirim data sesuai dengan variabel dengan metode POST


// menambah data yang ada pada tabel satuan berdasarka id dan nama
$perintah = $db->prepare("INSERT INTO gudang (id,kode_gudang,nama_gudang)
			VALUES (?,?,?)");

$perintah->bind_param("iss",
	$id, $kode_gudang, $nama_gudang);

	$id = angkadoang($_POST['id']);
	$kode_gudang = stringdoang($_POST['kode_gudang']);
	$nama_gudang = stringdoang($_POST['nama_gudang']);

$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo 'sukses';
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>