<?php 
include 'sanitasi.php';
include 'db.php';

$query = $db->query("DELETE FROM tbs_pembayaran_piutang");

if ($query == TRUE) {
	header('location:form_pembayaran_piutang.php');
}
else{
	echo"gagal";
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>