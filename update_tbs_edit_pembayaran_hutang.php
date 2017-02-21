<?php

include 'sanitasi.php';
include 'db.php';

$no_faktur_pembelian = $_POST['no_faktur_pembelian'];
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_bayar']);

$querypembayaran = $db->query("SELECT jumlah_bayar FROM detail_pembayaran_hutang WHERE no_faktur_pembelian = '$no_faktur_pembelian'");
$cekpemb = mysqli_fetch_array($querypembayaran);

$query5 = $db->query("SELECT kredit FROM pembelian WHERE no_faktur = '$no_faktur_pembelian'");
$cek5 = mysqli_fetch_array($query5);
$j_kredit = $cek5['kredit'];
$potongan_baru = angkadoang($_POST['potongan_baru']);
$potongan_lama = angkadoang($_POST['potongan']);
$a = $j_kredit + $cekpemb['jumlah_bayar'] + $potongan_lama - $potongan_baru;


if ($a < $jumlah_baru){

  echo '<div class="alert alert-danger">
            <strong>PERHATIAN!</strong> Jumlah Pembayaran Melebihi Hutang.
        </div>';

}

else{


$id = stringdoang($_POST['id']);
$jumlah_lama = angkadoang($_POST['jumlah_bayar']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$potongan_lama = angkadoang($_POST['potongan']);
$no_faktur_pembelian = stringdoang($_POST['no_faktur_pembelian']);
$potongan_baru = angkadoang($_POST['potongan_baru']);
$kredit = angkadoang($_POST['kredit']);

$jl = $jumlah_lama + $potongan_lama;

$a = $kredit - $potongan_baru;


$query = $db->prepare("UPDATE tbs_pembayaran_hutang SET potongan = ?, total = ?, jumlah_bayar = ?  WHERE id = ?");


$query->bind_param("iiii",
    $potongan_baru, $a, $jumlah_baru, $id);

$query->execute(); 



    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<div class="alert alert-info">
            <strong>SUKSES!</strong> Pembayaran Hutang Berhasil.
        </div>';
    }
}

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>