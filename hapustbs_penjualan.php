<?php session_start();
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$session_id = session_id();
$id = $_POST['id'];
$kode_barang = $_POST['kode_barang'];


//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_penjualan WHERE id = '$id'");

$query2 = $db->query("DELETE FROM tbs_fee_produk WHERE kode_produk = '$kode_barang' AND session_id = '$session_id' AND no_faktur IS NULL");

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
