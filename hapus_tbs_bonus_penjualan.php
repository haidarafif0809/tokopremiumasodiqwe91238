<?php session_start();
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$session_id = session_id();
$id = $_POST['idnya'];
$kode_barang = $_POST['kodenya'];

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_bonus_penjualan WHERE id = '$id' and kode_produk = '$kode_barang'");

//jika $query benar maka akan menuju file formpenjualan.php , jika salah maka failed
if ($query == TRUE)
{
echo 1;
}
else
{

}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
