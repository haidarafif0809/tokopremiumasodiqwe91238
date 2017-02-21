<?php

include 'sanitasi.php';
include 'db.php';

$query = $db->prepare("UPDATE tbs_kas_masuk SET jumlah = ? WHERE id = ?");

$query->bind_param("ii",
	$input_jumlah, $id);

$id = stringdoang($_POST['id']);

echo $input_jumlah = angkadoang($_POST['input_jumlah']);

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