<?php 
    //memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';

    $id_barang = angkadoang($_POST['id_barang']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $jumlah_barang= angkadoang($_POST['jumlah_barang']);
    $potongan = angkadoang($_POST['potongan']);

    $perintah = $db->prepare("INSERT INTO setting_diskon_jumlah (kode_barang, id_barang, syarat_jumlah, potongan)
			VALUES (?,?,?,?)");

    $perintah->bind_param("siii",
        $kode_barang, $id_barang, $jumlah_barang, $potongan);


    $perintah->execute();

    if (!$perintah) 
    {
     die('Query Error : '.$db->errno.
     ' - '.$db->error);
    }
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>