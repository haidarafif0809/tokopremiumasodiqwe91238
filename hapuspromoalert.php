<?php 
// memasukan file db.php
include 'db.php';

// mengirim data $id dengan menggunakan metode GET
$id = $_POST['id'];

// menghapus seluruh data yang ada pada tabel barang berdasrkan id
$query = $db->query("DELETE FROM promo_alert WHERE id_promo_alert = '$id'");

// logika => jika $query benar maka akan menuju file barang.php , jika salah maka failed
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
