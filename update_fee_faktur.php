<?php
include 'sanitasi.php';
include 'db.php';


$id = stringdoang($_POST['id']);
$prosentase = angkadoang($_POST['jumlah_prosentase']);
$nominal = angkadoang($_POST['jumlah_uang']);


$query = $db->prepare("UPDATE fee_faktur SET jumlah_prosentase = ?, jumlah_uang = ? WHERE id = ?");

$query->bind_param("iis",
	$prosentase, $nominal, $id);

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