<?php
include 'sanitasi.php';
include 'db.php';


$pot_jual = stringdoang($_POST['pot_jual']);
$pajak_jual = stringdoang($_POST['pajak_jual']);
$bayar_tunai = stringdoang($_POST['bayar_tunai']);
$bayar_kredit = stringdoang($_POST['bayar_kredit']);
$komisi_sales = stringdoang($_POST['komisi_sales']);
$pot_retur_jual = stringdoang($_POST['pot_retur_jual']);
$pajak_retur_jual = stringdoang($_POST['pajak_retur_jual']);
$bayar_tunai_retur = stringdoang($_POST['bayar_tunai_retur']);
$bayar_kredit_retur = stringdoang($_POST['bayar_kredit_retur']);
$bayar_komisi_retur = stringdoang($_POST['bayar_komisi_retur']);



$update = $db->prepare("UPDATE setting_akun SET potongan_jual = ?, pajak_jual = ?, pembayaran_tunai = ?, pembayaran_kredit = ?, komisi_sales = ?, potongan_retur_jual = ?, pajak_retur_jual = ?, tunai_retur_jual = ?, kredit_retur_jual = ?, komisi_sales_retur_jual = ? ");

$update->bind_param("ssssssssss",
	$pot_jual, $pajak_jual, $bayar_tunai, $bayar_kredit, $komisi_sales, $pot_retur_jual, $pajak_retur_jual, $bayar_tunai_retur, $bayar_kredit_retur, $bayar_komisi_retur);

$update->execute();


    if (!$update) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_akun_data_penjualan.php">';
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>