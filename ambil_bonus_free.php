<?php session_start();
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';

    $session_id = session_id();

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_bonus']);
    $jumlah = angkadoang($_POST['jumlah']);
    $satuan = angkadoang($_POST['satuan']);
    $harga_disc = angkadoang($_POST['harga_disc']);
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    $select = $db->query("SELECT kode_produk,keterangan FROM tbs_bonus_penjualan WHERE kode_produk = '$kode_barang' AND session_id = '$session_id' AND tanggal = '$tanggal' AND keterangan = 'Free Produk'");
    $tbs = mysqli_num_rows($select);
    if ($tbs > 0) {
        $update = $db->query("UPDATE tbs_bonus_penjualan SET qty_bonus = '$jumlah' WHERE session_id = '$session_id' ");
    }
    else{

        $perintah = $db->prepare("INSERT INTO tbs_bonus_penjualan (session_id,kode_produk,nama_produk,qty_bonus,keterangan,tanggal,jam,satuan,harga_disc) VALUES (?,?,?,?,'Free Produk',?,?,?,?)");

        $perintah->bind_param("sssissii",
          $session_id, $kode_barang, $nama_barang, $jumlah,$tanggal,$jam,$satuan,$harga_disc);
          

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