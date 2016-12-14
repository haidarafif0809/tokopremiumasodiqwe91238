<?php
include 'sanitasi.php';
include 'db.php';


$id = stringdoang($_POST['id']);
$nama = stringdoang($_POST['nama']);



$query = $db->prepare("UPDATE satuan SET id = ?, nama = ? WHERE id = ?");

$query->bind_param("sss",
	$id, $nama, $id);

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