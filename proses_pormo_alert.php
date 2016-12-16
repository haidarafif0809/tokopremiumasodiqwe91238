<?php 
//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

	//mengirim data sesuai dengan variabel dengan metode POST

// menambah data yang ada pada tabel satuan berdasarka id dan nama
$perintah = $db->prepare("INSERT INTO promo_alert (id_produk,pesan_alert,status)
			VALUES (?,?,?)");

$perintah->bind_param("iss",$id_produk,$pesan_alert,$status);


	$id_produk = stringdoang($_POST['id_produk']);
	$pesan_alert = $_POST['pesan_alert'];
	$status = stringdoang($_POST['status']);

$perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=promo_alert.php">';


 ?>