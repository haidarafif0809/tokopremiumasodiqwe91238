<?php session_start();

include 'sanitasi.php';
include 'db.php';

$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$subtotal = angkadoang($_POST['subtotal']);
$id = angkadoang($_POST['id']);

$query = $db->prepare("UPDATE tbs_tukar_poin SET jumlah_barang = ?, subtotal_poin = ? WHERE id = ?");

$query->bind_param("iii",
    $jumlah_baru, $subtotal, $id);

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
