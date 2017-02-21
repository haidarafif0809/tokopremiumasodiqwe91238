<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];



//menghapus se+uruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_pembelian WHERE id = '$id'");

//jika $query benar maka akan menuju file formpembelian.php , jika salah maka failed
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
