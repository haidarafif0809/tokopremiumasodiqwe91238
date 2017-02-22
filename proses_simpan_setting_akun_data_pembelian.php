<?php
include 'sanitasi.php';
include 'db.php';


$pot_beli = stringdoang($_POST['pot_beli']);
$pajak_beli = stringdoang($_POST['pajak_beli']);
$bayar_tunai = stringdoang($_POST['bayar_tunai']);
$bayar_kredit = stringdoang($_POST['bayar_kredit']);
$pot_retur_beli = stringdoang($_POST['pot_retur_beli']);
$pajak_retur_beli = stringdoang($_POST['pajak_retur_beli']);
$bayar_retur_tunai = stringdoang($_POST['bayar_retur_tunai']);
$bayar_retur_kredit = stringdoang($_POST['bayar_retur_kredit']);



$update = $db->prepare("UPDATE setting_akun SET potongan = ?, pajak = ?, pembayaran_tunai = ?, hutang = ?, potongan_retur_beli = ?, pajak_retur_beli = ?, tunai_retur_beli = ?, kredit_retur_beli = ?");
$update->bind_param("ssssssss",
	$pot_beli, $pajak_beli, $bayar_tunai, $bayar_kredit, $pot_retur_beli, $pajak_retur_beli, $bayar_retur_tunai, $bayar_retur_kredit);

$update->execute();


    if (!$update) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_akun_data_pembelian.php">';
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>