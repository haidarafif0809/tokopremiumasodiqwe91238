<?php
include 'sanitasi.php';
include 'db.php';

$target_baru = stringdoang($_POST['target_baru']); 
$hitung_proyeksi = stringdoang($_POST['hitung_proyeksi']); 
$kebutuhan = stringdoang($_POST['kebutuhan']); 
$id = stringdoang($_POST['id']); 

$query = $db->prepare("UPDATE tbs_target_penjualan SET target_perhari = ? , proyeksi = ?, kebutuhan = ? WHERE id = ? ");

$query->bind_param("iiii",
	$target_baru,$hitung_proyeksi,$kebutuhan,$id);


$query->execute();


    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
   
    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>