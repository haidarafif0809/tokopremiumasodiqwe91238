<?php session_start();
    // memasukan file db.php
    include 'db.php';
     include 'sanitasi.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 

    $kode_parcel = stringdoang($_GET['kode_parcel']);

    // menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
    $query = $db->query("DELETE FROM tbs_parcel WHERE kode_parcel = '$kode_parcel'");



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>