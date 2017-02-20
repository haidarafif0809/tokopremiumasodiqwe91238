<?php session_start();


include 'sanitasi.php';
include 'db.php';

$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$kode_parcel = stringdoang($_POST['kode_parcel']);


$query = $db->prepare("UPDATE perakitan_parcel SET jumlah_parcel = ? WHERE kode_parcel = ? ");

$query->bind_param("ii",
    $jumlah_baru, $kode_parcel);

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
