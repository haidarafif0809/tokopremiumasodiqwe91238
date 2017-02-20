<?php 
//memasukan file db.php
include 'db.php';

$session_id = session_id();
//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];
$no_pesanan = $_POST['no_pesanan'];



//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM detail_penjualan WHERE id = '$id' AND no_pesanan = '$no_pesanan'");


//jika $query benar maka akan menuju file formpenjualan.php , jika salah maka failed
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
