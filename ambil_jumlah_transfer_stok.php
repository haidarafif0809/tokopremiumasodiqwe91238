<?php session_start();

include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$session_id = session_id();

    $kode_barang = stringdoang($_POST['kode_barang']);

    $stok_barang = cekStokHpp($kode_barang);

    $query_tbs_transfer_stok = $db->query("SELECT SUM(jumlah) AS jumlah_barang FROM tbs_transfer_stok WHERE session_id = '$session_id' AND (no_faktur IS NULL OR no_faktur = '') AND kode_barang = '$kode_barang'");
    $data_tbs_transfer_stok = mysqli_fetch_array($query_tbs_transfer_stok);

    $stok_sebenarnya = $stok_barang - $data_tbs_transfer_stok['jumlah_barang'];

    echo $stok_sebenarnya;


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>