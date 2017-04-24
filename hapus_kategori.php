<?php 

// memasukan file db.php
include 'db.php';


$id = $_POST['id'];


$query = $db->query("DELETE FROM kategori WHERE id = '$id'");


if ($query == TRUE)
{

	echo "sukses";

}

else
{
	
	echo "gagal";
	}	

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
