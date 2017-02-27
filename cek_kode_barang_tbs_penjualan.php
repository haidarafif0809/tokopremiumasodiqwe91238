<?php session_start();

include 'db.php';

$session_id = session_id();
$kode_barang = $_POST['kode_barang'];

$query = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang' AND session_id = '$session_id' AND (no_faktur_order = '' OR no_faktur_order IS NULL ) ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

