<?php session_start();
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    include 'persediaan.function.php';

    $session_id = session_id();
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');



    $kode_barang = stringdoang($_POST['kode_barang']);
    
    $query_select_bonus = $db->query("SELECT kode_produk FROM tbs_bonus_penjualan WHERE kode_produk = '$kode_barang'");
    $data_query_bonus = mysqli_fetch_array($query_select_bonus);
    $kode_barang_tbs = $data_query_bonus['kode_produk'];

    if($kode_barang == $kode_barang_tbs){
    	echo 1;
    }
    else{
    	echo 0;
    }

?>