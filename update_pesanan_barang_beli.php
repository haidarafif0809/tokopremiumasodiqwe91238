<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_lama']);
$potongan = angkadoang($_POST['potongan']);
$harga = angkadoang($_POST['harga']);
$tax = angkadoang($_POST['jumlah_tax']);
$jumlah_tax = round($tax);
$subtotal = angkadoang($_POST['sub_tampil']);

$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);

$query00 = $db->query("SELECT * FROM tbs_pembelian WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$kode = $data['kode_barang'];
$nomor = $data['no_faktur'];

$query = $db->prepare("UPDATE tbs_pembelian SET jumlah_barang = ?, subtotal = ?, tax = ? WHERE id = ?");


$query->bind_param("iiii",
    $jumlah_baru, $subtotal, $jumlah_tax, $id);

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
