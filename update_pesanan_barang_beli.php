<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_lama']);
$potongan = angkadoang($_POST['potongan']);
$harga = angkadoang($_POST['harga']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);

$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);


$subtotal = $harga * $jumlah_baru - $potongan;

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
