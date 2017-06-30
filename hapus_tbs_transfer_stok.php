<?php 

//memasukan file db.php
include 'db.php';
include 'sanitasi.php';

//mengirimkan $id menggunakan metode GET
$id = angkadoang($_POST['id']);

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_transfer_stok WHERE id = '$id'");

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
