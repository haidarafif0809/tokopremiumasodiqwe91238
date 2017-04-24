<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET

$id = $_POST['id'];

$query2 = $db->query("DELETE FROM satuan_konversi WHERE id = '$id'");


if ($query == TRUE)
{
echo "sukses";
}
else
{
	
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
