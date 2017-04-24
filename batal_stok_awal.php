<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET

$kode_barang = $_GET['kode_barang'];



$query1 = $db->query("SELECT * FROM tbs_stok_awal WHERE kode_barang = '$kode_barang'");
$data =mysqli_fetch_array($query1);



    	
$query = $db->query("UPDATE barang SET stok_awal = '' WHERE kode_barang = '$data[kode_barang]'");

//menghapus seluruh data yang ada pada tabel tbs_pembelian berdasarkan id
$query = $db->query("DELETE FROM tbs_stok_awal WHERE kode_barang = '$kode_barang'");

//jika $query benar maka akan menuju file formpembelian.php , jika salah maka failed
if ($query == TRUE)
{
	header('location:form_stok_awal.php');
}
else
{
	echo "gagal";
}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
?>
