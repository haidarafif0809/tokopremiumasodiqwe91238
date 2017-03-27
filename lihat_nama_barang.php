<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_cek = substr(stringdoang($_GET['kode_barang']),0,2);

   $lihat_setting = $db->query("SELECT kode_flag FROM setting_timbangan");
$kel_setting = mysqli_fetch_array($lihat_setting);
$setting_flag = $kel_setting['kode_flag'];


if ($kode_cek == $setting_flag)
{
    $kode_barang = substr(stringdoang($_GET['kode_barang']),2,5);
}
else
{
  $kode_barang = stringdoang($_GET['kode_barang']);
}


$result = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");
$row = mysqli_fetch_array($result);
   
    echo $row;


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>