<?php 
//memasukan file db.php
include 'db.php';


$kode_barang = $_POST['kode_barang'];




    	
$query0 = $db->query("UPDATE barang SET stok_opname = '' WHERE kode_barang = '$kode_barang'");


$query = $db->query("DELETE FROM tbs_stok_opname WHERE kode_barang = '$kode_barang'");


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
