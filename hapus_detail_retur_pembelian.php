<?php 

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_GET['id'];

//menghapus seluruh data yang ada pada tabel kas berdasarkan id
$query = $db->query("DELETE FROM detail_retur_pembelian WHERE id = '$id'");

//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($query == TRUE)
{

header('location:detail_retur_pembelian.php');
}
else
{
	echo "failed";
	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
