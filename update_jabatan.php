<?php
include 'sanitasi.php';
include 'db.php';



$query = $db->prepare("UPDATE jabatan SET id = ?, nama = ? 
WHERE id = ?");

$query->bind_param("sss",
	$id, $nama, $id);
	
	$id = stringdoang($_POST['id']);
	$nama = stringdoang($_POST['nama']);

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