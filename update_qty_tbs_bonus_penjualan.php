<?php session_start();

include 'sanitasi.php';
include 'db.php';

$kode_barang = stringdoang($_POST['kodenya']);
$jumlah = angkadoang($_POST['jumlah']);

$id = stringdoang($_POST['idnya']);


$query = $db->prepare("UPDATE tbs_bonus_penjualan SET qty_bonus = ? WHERE id = ?");


$query->bind_param("ii",
    $jumlah, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {

    }

?>