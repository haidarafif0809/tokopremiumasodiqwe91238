<?php

include 'db.php';
include 'sanitasi.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$kode_barang = stringdoang($_POST['kode_barang']);

$query = $db->query("SELECT kode_barang FROM tbs_pembelian_order WHERE kode_barang = '$kode_barang' AND no_faktur_order = '$no_faktur'");
$jumlah = mysqli_num_rows($query);

if ($jumlah > 0){

  echo "1";
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>