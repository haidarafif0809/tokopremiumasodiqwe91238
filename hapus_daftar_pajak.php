<?php 

include 'db.php';


$id = $_POST['id'];


$query = $db->query("DELETE FROM daftar_pajak WHERE id = '$id'");


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
