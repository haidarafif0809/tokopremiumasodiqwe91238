<?php

include 'sanitasi.php';
include 'db.php';


$no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_bayar']);

$query5 = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$no_faktur_penjualan'");
$cek5 = mysqli_fetch_array($query5);
$j_kredit = $cek5['kredit'];

$detail_piutang = $db->query("SELECT jumlah_bayar, potongan FROM tbs_pembayaran_piutang WHERE no_faktur_penjualan = '$no_faktur_penjualan'");
$cek0 = mysqli_fetch_array($detail_piutang);
$cek0['jumlah_bayar'];
$t_kredit = $j_kredit + $cek0['jumlah_bayar'] + $cek0['potongan'];

$kredit = $t_kredit - $jumlah_baru;

if ($kredit < 0){

  echo '<div class="alert alert-danger">
            <strong>PERHATIAN!</strong> Jumlah Pembayaran Melebihi Piutang.
        </div>';

}

else{

$id = stringdoang($_POST['id']);
$jumlah_lama = angkadoang($_POST['jumlah_bayar']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$potongan_baru = angkadoang($_POST['potongan_baru']);
$potongan_lama = angkadoang($_POST['potongan']); 
$no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
$kredit = angkadoang($_POST['kredit']);

$jl = $jumlah_lama + $potongan_lama;

$a = $kredit - $potongan_baru;




$query = $db->prepare("UPDATE tbs_pembayaran_piutang SET potongan = ?, total = ?, jumlah_bayar = ? WHERE id = ?");


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
            <strong>SUKSES!</strong> Pembayaran Piutang Berhasil.
        </div>';
    }

}

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>