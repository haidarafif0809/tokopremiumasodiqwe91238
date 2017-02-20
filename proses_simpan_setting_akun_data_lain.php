<?php
include 'sanitasi.php';
include 'db.php';


$kas = stringdoang($_POST['kas']);
$prive = stringdoang($_POST['prive']);
$laba_ditahan = stringdoang($_POST['laba_ditahan']);
$laba_tahun_berjalan = stringdoang($_POST['laba_tahun_berjalan']);
$balancing = stringdoang($_POST['balancing']);



$update = $db->prepare("UPDATE setting_akun SET kas = ?, prive = ?, laba_ditahan = ?, laba_tahun_berjalan = ?, balancing = ?");

$update->bind_param("sssss",
	$kas, $prive, $laba_ditahan, $laba_tahun_berjalan, $balancing);

$update->execute();


    if (!$update) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_akun_data_lain.php">';
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>