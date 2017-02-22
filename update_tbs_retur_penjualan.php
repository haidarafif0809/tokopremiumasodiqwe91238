<?php
include 'sanitasi.php';
include 'db.php';

$id = stringdoang($_POST['id']);
$jumlah_retur = angkadoang($_POST['jumlah_retur']);
$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);


$harga = angkadoang($_POST['harga']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);
$potongan = angkadoang($_POST['potongan']);


$query5 = $db->query("SELECT * FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
$cek5 = mysqli_fetch_array($query5);

$j_retur = $cek5['sisa'];
$a = $j_retur  + $jumlah_retur;


if ($a < $jumlah_baru){

  echo '<div class="alert alert-danger">
            <strong>PERHATIAN!</strong> Jumlah Retur Melebihi Sisa Barang.
        </div>';

}

else{

    
    $kode_barang = stringdoang($_POST['kode_barang']);
    $jumlah_retur = angkadoang($_POST['jumlah_retur']);
    $jumlah_baru = angkadoang($_POST['jumlah_baru']);


$query1 = $db->prepare("UPDATE detail_penjualan SET sisa = sisa + ? WHERE kode_barang = ?");

$query1->bind_param("is",
	$jumlah_retur, $kode_barang);

$query1->execute();




$query2 = $db->prepare("UPDATE detail_penjualan SET sisa = sisa - ? WHERE kode_barang = ?");

$query2->bind_param("is",
	$jumlah_baru, $kode_barang);

$query2->execute();




$query = $db->prepare("UPDATE tbs_retur_penjualan SET jumlah_beli = ?, jumlah_retur = ?, subtotal = ?, tax = ? WHERE id = ?");

$query->bind_param("iiiii",
	$jumlah_beli, $jumlah_baru, $subtotal, $jumlah_tax, $id);

$jumlah_beli = angkadoang($_POST['jumlah_beli']);
$harga = angkadoang($_POST['harga']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);

$subtotal = $harga * $jumlah_baru;

$query->execute();



    if (!$query1) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<div class="alert alert-info">
            <strong>SUKSES!</strong> Retur Berhasil.
        </div>';
    }

}

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>