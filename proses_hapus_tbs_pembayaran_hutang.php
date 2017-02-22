<?php 
include 'sanitasi.php';
include 'db.php';

$query = $db->query("DELETE FROM tbs_pembayaran_hutang");

if ($query == TRUE) {
	header('location:form_pembayaran_hutang.php');
}
else{
	echo"gagal";
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>