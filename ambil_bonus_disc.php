<?php session_start();
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    $session_id = session_id();
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_bonus']);
    $jumlah = angkadoang($_POST['jumlah']);
    $harga = angkadoang($_POST['harga']);
    $qty_max = angkadoang($_POST['qty_max']);
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');
        $perintah = $db->prepare("INSERT INTO tbs_bonus_penjualan (session_id,kode_produk,nama_produk,qty_bonus,keterangan,tanggal,jam,harga_disc) VALUES (?,?,?,?,'Disc Produk',?,?,?)");

        $perintah->bind_param("sssissi",
          $session_id, $kode_barang, $nama_barang, $jumlah,$tanggal,$jam,$harga);
          

        $perintah->execute();

        if (!$perintah) 
        {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }
        else 
        {
           
        }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>