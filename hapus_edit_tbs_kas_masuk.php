<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_kas_masuk WHERE id = '$id'");

//jika $query benar maka akan menuju file formpenjualan.php , jika salah maka failed
if ($query == TRUE)
{
	
	echo "1";
	
}
else
{

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
