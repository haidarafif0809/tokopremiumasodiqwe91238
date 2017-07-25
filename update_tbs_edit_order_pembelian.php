<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_lama']);
$potongan = angkadoang($_POST['potongan']);
$harga = angkadoang($_POST['harga']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);
$subtotal = angkadoang($_POST['subtotal']);
$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);

$query = $db->prepare("UPDATE tbs_pembelian_order SET jumlah_barang = ?, subtotal = ?, tax = ? WHERE id = ?");


$query->bind_param("iiii",
    $jumlah_baru, $subtotal, $jumlah_tax, $id);

$query->execute();

    if (!$query) {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
    }
    else {

    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>