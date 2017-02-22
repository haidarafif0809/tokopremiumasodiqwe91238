<?php
include 'sanitasi.php';
include 'db.php';

    $kode_daftar_akun = stringdoang($_POST['kode_daftar_akun']);
    $kas_default = stringdoang($_POST['kas_default']);

if ($kas_default != '') {

$query = $db->prepare("UPDATE setting_akun SET kas = ? ");

$query->bind_param("s",
    $kode_daftar_akun);
    
    $kode_daftar_akun = stringdoang($_POST['kode_daftar_akun']);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
header('location:kas.php');
    }


}

else{

$query = $db->query("UPDATE setting_akun SET kas = '' ");

header('location:kas.php');
}




    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>

