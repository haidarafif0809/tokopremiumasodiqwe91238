<?php 

include 'db.php';

$no_faktur_retur = $_POST['no_faktur_retur'];
$kode_barang = $_POST['kode_barang'];

$query = $db->query("SELECT kode_barang FROM tbs_retur_pembelian WHERE kode_barang = '$kode_barang' AND no_faktur_retur = '$no_faktur_retur'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

