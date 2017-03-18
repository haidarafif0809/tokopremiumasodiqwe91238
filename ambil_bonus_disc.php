<?php session_start();
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    $session_id = session_id();
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_bonus']);
    $jumlahnya = angkadoang($_POST['jumlah']);
    $harga = angkadoang($_POST['harga']);
    $qty_max = angkadoang($_POST['qty_max']);
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    if ($jumlahnya > $qty_max) {
        $jumlah = $qty_max;
    }
    else{
        $jumlah = $jumlahnya;
    }

    $select = $db->query("SELECT kode_produk,keterangan FROM tbs_bonus_penjualan WHERE kode_produk = '$kode_barang' AND session_id = '$session_id' AND tanggal = '$tanggal' AND keterangan = 'Disc Produk'");
    $tbs = mysqli_num_rows($select);
    if ($tbs > 0) {
        $update = $db->query("UPDATE tbs_bonus_penjualan SET qty_bonus = '$jumlah'");
    }
    else{
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
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>