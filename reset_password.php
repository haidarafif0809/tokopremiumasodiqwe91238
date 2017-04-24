<?php
include 'sanitasi.php';
include 'db.php';


$id = stringdoang($_POST['id']);
$password = enkripsi('1234');



$query = $db->prepare("UPDATE user SET password = ? WHERE id = ? ");

$query->bind_param("ss",
	$password,$id);

$query->execute();


    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo "sukses";
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>