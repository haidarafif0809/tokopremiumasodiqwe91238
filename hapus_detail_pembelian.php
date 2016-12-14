<?php 

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$no_faktur = $_GET['no_faktur'];

//menghapus seluruh data yang ada pada tabel kas berdasarkan id
$query = $db->query("DELETE FROM detail_pembelian WHERE no_faktur = '$no_faktur'");

//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($query == TRUE)
{

header('location:detail_pembelian.php');
}
else
{
	echo "failed";
	}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
