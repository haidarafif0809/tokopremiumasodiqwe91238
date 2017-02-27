<?php session_start();

include 'db.php';
include 'sanitasi.php';


$session_id = session_id();
$kode_barang = stringdoang($_POST['kode_barang']);
$no_faktur_order = stringdoang($_POST['no_faktur_order']);

$query = $db->query("SELECT kode_barang FROM tbs_penjualan_order WHERE kode_barang = '$kode_barang' AND no_faktur_order = '$no_faktur_order'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>