<?php
include 'sanitasi.php';
include 'db.php';

$query = $db->query("SELECT nama_daftar_akun, kode_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank'");
$data = mysqli_fetch_array($query);

$query0 = $db->query("SELECT kas FROM setting_akun WHERE kas = '$data[kode_daftar_akun]'");
$default = mysqli_num_rows($query0);

    $status = stringdoang($_POST['kas']);

    if ($status == ''){


$query = $db->prepare("UPDATE setting_akun SET kas = ?
WHERE id = ?");

$query->bind_param("si",
    $status, $id);
    
    $id = angkadoang($_POST['id']);
    $status = stringdoang($_POST['kas']);


$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    header ('location:kas.php');
    
    }

    }

    else {
if ($default > 0) {

$query_update = $db->query("UPDATE setting_akun SET kas = '' ");

$query = $db->prepare("UPDATE setting_akun SET kas = ?
WHERE id = ?");

$query->bind_param("si",
    $status, $id);
    
    $id = angkadoang($_POST['id']);
    $status = stringdoang($_POST['kas']);
$query->execute();

if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    header ('location:kas.php');
    }



}

else {

$query = $db->prepare("UPDATE setting_akun SET kas = ?
WHERE id = ?");

$query->bind_param("si",
    $status, $id);
    
    $id = angkadoang($_POST['id']);
    $status = stringdoang($_POST['kas']);


$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    header ('location:kas.php');
    
    }

}

        
    }



    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


?>

