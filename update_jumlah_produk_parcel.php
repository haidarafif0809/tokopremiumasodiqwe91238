<?php session_start();


include 'sanitasi.php';
include 'db.php';

$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_lama']);
$id = stringdoang($_POST['id_produk']);
$kode_parcel = $_POST['kode_parcel'];


$query = $db->prepare("UPDATE tbs_parcel SET jumlah_produk = ? WHERE id_produk = ? AND kode_parcel = ?");

$query->bind_param("iii",
    $jumlah_baru, $id, $kode_parcel);

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
