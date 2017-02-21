<?php
include 'sanitasi.php';
include 'db.php';


$id = stringdoang($_POST['id']);
$nama = stringdoang($_POST['nama_meja']);



$query = $db->prepare("UPDATE meja SET nama_meja = ? WHERE id = ?");

$query->bind_param("ss",
    $nama, $id);

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