<?php 

include 'sanitasi.php';
include 'db.php';

$query = $db->prepare("UPDATE tbs_penjualan SET komentar = ?
WHERE id = ?");

$query->bind_param("si",
    $komentar, $id);
    
    $id = angkadoang($_POST['id']);
    $komentar = stringdoang($_POST['komentar']);

$query->execute();

if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>