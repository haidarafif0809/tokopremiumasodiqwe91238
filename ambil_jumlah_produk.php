<?php 

include 'db.php';
include 'sanitasi.php';

    $kode_barang = stringdoang($_POST['kode_barang']);

	$select = $db->query("SELECT SUM(sisa) AS jumlah_barang FROM hpp_masuk WHERE kode_barang = '$kode_barang'");
    $ambil_sisa = mysqli_fetch_array($select);
    echo $ambil_sisa['jumlah_barang'];


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>