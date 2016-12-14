<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];
$kode_barang = $_POST['kode_barang'];
echo $no_faktur = $_POST['no_faktur'];



$query1 = $db->query("SELECT * FROM tbs_retur_penjualan WHERE kode_barang = '$kode_barang'");
$cek =mysqli_fetch_array($query1);

$jumlah = $cek['jumlah_retur'];

    	
$query2 = $db->query("UPDATE detail_penjualan SET sisa = sisa + '$jumlah' WHERE no_faktur = '$no_faktur'");


$query = $db->query("DELETE FROM tbs_retur_penjualan WHERE id = '$id'");


if ($query == TRUE)
{

}
else
{
	
	}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
