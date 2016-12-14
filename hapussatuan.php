<?php 


include 'db.php';



$id = $_POST['id'];


$query = $db->query("DELETE FROM satuan WHERE id = '$id'");


if ($db->query($query) === TRUE) 
{

	echo"sukses";
  
} 

else
{
    echo "Gagal";
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>