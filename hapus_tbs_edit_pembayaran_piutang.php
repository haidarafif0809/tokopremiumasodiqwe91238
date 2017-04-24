<?php 
//memasukan file db.php
include 'db.php';


$id = $_POST['id'];


//menghapus seluruh data yang ada pada tabel tbs_pembelian berdasarkan id
$hapus = $db->query("DELETE FROM tbs_pembayaran_piutang WHERE id = '$id'");

//jika $query benar maka akan menuju file formpembelian.php , jika salah maka failed
if ($hapus == TRUE)
{
	echo "sukses";
}
else
{

}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
