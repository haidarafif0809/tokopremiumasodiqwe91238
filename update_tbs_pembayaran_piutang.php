<?php

include 'sanitasi.php';
include 'db.php';


$no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_bayar']);

$query5 = $db->query("SELECT kredit FROM penjualan WHERE no_faktur = '$no_faktur_penjualan'");
$cek5 = mysqli_fetch_array($query5);
$j_kredit = $cek5['kredit'];
$potongan_baru = angkadoang($_POST['potongan_baru']);

$a = $j_kredit - $jumlah_baru - $potongan_baru;

if ($a < 0){

  echo '<div class="alert alert-danger">
            <strong>PERHATIAN!</strong> Jumlah Pembayaran Melebihi Piutang.
        </div>';

}

else{

$id = stringdoang($_POST['id']);
$jumlah_lama = angkadoang($_POST['jumlah_bayar']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$no_faktur_penjualan = stringdoang($_POST['no_faktur_penjualan']);
$potongan_baru = angkadoang($_POST['potongan_baru']);
$kredit = angkadoang($_POST['kredit']);

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