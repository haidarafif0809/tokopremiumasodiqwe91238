<?php
include 'sanitasi.php';
include 'db.php';


$pot_hutang = stringdoang($_POST['pot_hutang']);
$pot_piutang = stringdoang($_POST['pot_piutang']);



$update = $db->prepare("UPDATE setting_akun SET potongan_hutang = ?, potongan_piutang = ? ");

$update->bind_param("ss",
	$pot_hutang, $pot_piutang);

$update->execute();


    if (!$update) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_akun_data_hutang_piutang.php">';
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>