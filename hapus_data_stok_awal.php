<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$kode_barang = $_POST['kode_barang'];
$no_faktur = $_POST['no_faktur'];
$user = $_SESSION['user_name'];

 // INSERT HISTORY STOK AWAL
$stok_awal = $db->query("SELECT * FROM stok_awal WHERE no_faktur = '$no_faktur' AND kode_barang = '$kode_barang'");
$data_stok_awal = mysqli_fetch_array($stok_awal);

$insert_stok_awal = $db->query("INSERT INTO history_stok_awal (no_faktur, kode_barang, nama_barang, jumlah_awal, satuan, harga, total, gudang, tanggal, jam, user, tanggal_edit, user_edit, user_hapus) VALUES ('$no_faktur','$data_stok_awal[kode_barang]','$data_stok_awal[nama_barang]', '$data_stok_awal[jumlah_awal]', '$data_stok_awal[satuan]', '$data_stok_awal[harga]','$data_stok_awal[total]','$data_stok_awal[gudang]', '$data_stok_awal[tanggal]' ,'$data_stok_awal[jam]','$data_stok_awal[user]','$data_stok_awal[tanggal_edit]','$data_stok_awal[user_edit]','$user')");


    
        if ($insert_stok_awal == TRUE)
        {
        
        echo "sukses";
        }
        else
        {
        
        }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
