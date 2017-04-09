<?php 
//memasukan file db.php
include 'db.php';
include 'sanitasi.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$id = angkadoang($_POST['id']);

    	
$query0 = $db->query("UPDATE barang SET stok_opname = '' WHERE kode_barang = '$kode_barang'");


$query = $db->query("DELETE FROM tbs_stok_opname WHERE kode_barang = '$kode_barang' AND id = '$id' ");


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
