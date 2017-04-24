<?php 

// memasukan file session login,  header, navbar, db.php,

include 'db.php';

$kode_barang = $_POST['kode_barang'];
$no_faktur_pembelian = $_POST['no_faktur_beli'];
$jumlah_retur = $_POST['jumlah_retur'];


 $query = $db->query("SELECT sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur_pembelian'");
 $data_query = mysqli_fetch_array($query);

echo $stok = $data_query['sisa'];



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
 ?>



