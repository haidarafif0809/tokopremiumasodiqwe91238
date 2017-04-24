<?php 

include 'db.php';

$no_faktur = $_POST['no_faktur'];
$kode_barang = $_POST['kode_barang'];

$query = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
$data = mysqli_fetch_array($query);

echo $jumlah_tbs = $data['jumlah_barang'];

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

