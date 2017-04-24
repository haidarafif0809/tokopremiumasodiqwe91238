<?php 


include 'db.php';



$id = $_POST['id'];


$query = $db->query("DELETE FROM fee_faktur WHERE id = '$id'");


if ($db->query($query) === TRUE) 
{

	echo"sukses";
  
} 

else
{
 
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>