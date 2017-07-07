<?php 
//memasukan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET

$query1 = $db->query("SELECT kode_barang FROM tbs_stok_awal ");
while ($data =mysqli_fetch_array($query1)) {
	

$query = $db->query("DELETE FROM tbs_stok_awal WHERE kode_barang = '$data[kode_barang]'");
    	
$query = $db->query("UPDATE barang SET stok_awal = '' WHERE kode_barang = '$data[kode_barang]'");

}
	


	header('location:form_stok_awal.php');



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
?>
