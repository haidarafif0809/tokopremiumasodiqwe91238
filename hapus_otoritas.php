<?php 

// memasukan file db.php
include 'db.php';


$id = $_POST['id'];

$hapus = $db->query("SELECT otoritas FROM akses");
$ambil = mysqli_fetch_array($hapus);
echo $otoritas = $ambil['otoritas'];

$query = $db->query("DELETE FROM hak_otoritas WHERE id = '$id'");

$query = $db->query("DELETE FROM akses WHERE id = '$id'");


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
