<?php
include 'sanitasi.php';
include 'db.php';


$hpp = stringdoang($_POST['hpp']);
$pend_jual = stringdoang($_POST['pend_jual']);
$persediaan = stringdoang($_POST['persediaan']);
$item_masuk = stringdoang($_POST['item_masuk']);
$item_keluar = stringdoang($_POST['item_keluar']);
$s_opname = stringdoang($_POST['s_opname']);
$s_awal = stringdoang($_POST['s_awal']);



$update = $db->prepare("UPDATE setting_akun SET hpp_penjualan = ?, total_penjualan = ?, persediaan = ?, item_masuk = ?, item_keluar = ?, pengaturan_stok = ?, stok_awal = ? ");

$update->bind_param("sssssss",
	$hpp, $pend_jual, $persediaan, $item_masuk, $item_keluar, $s_opname, $s_awal);

$update->execute();


    if (!$update) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_akun_data_item.php">';
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>