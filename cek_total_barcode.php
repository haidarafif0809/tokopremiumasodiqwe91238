<?php session_start();

// memasukan file db.php
include 'db.php';
include 'sanitasi.php';


$session_id = session_id();
 $kode_barang = stringdoang($_POST['kode_barang']);
 $level_harga = stringdoang($_POST['level_harga']);
 $jumlah_barang = angkadoang(1);


$query = $db->query("SELECT harga_jual,harga_jual2,harga_jual3, FROM barang WHERE kode_barang = '$kode_barang'");
$result = mysqli_fetch_array($query);

    $harga_jual1 = angkadoang($result['harga_jual']);
    $harga_jual2 = angkadoang($result['harga_jual2']);
    $harga_jual3 = angkadoang($result['harga_jual3']);

if ($level_harga == 'Level 1')
{
  $harga = $harga_jual1;
}
elseif ($level_harga == 'Level 2')
{
  $harga = $harga_jual2;
}
elseif ($level_harga == 'Level 3')
{
  $harga = $harga_jual3;
}


echo $total_barcode = $harga * $jumlah_barang;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>
