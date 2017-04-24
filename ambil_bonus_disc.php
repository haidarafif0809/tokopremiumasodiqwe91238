<?php session_start();
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    include 'persediaan.function.php';

    $session_id = session_id();
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);

    $stok = cekStokHpp($kode_barang);
    $nama_barang = stringdoang($_POST['nama_bonus']);
    $jumlah = angkadoang($_POST['jumlah']);
    $harga = angkadoang($_POST['harga']);
    $satuan = angkadoang($_POST['satuan']);
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    $hasil = $stok - $jumlah;
    //cek stok barang, jika barang masih ada maka akan masuk,
    if ($hasil < 0) {
        echo 1;
    }
    else{
        $perintah = $db->prepare("INSERT INTO tbs_bonus_penjualan (session_id,kode_produk,nama_produk,qty_bonus,keterangan,tanggal,jam,harga_disc,satuan) VALUES (?,?,?,?,'Disc Produk',?,?,?,?)");

        $perintah->bind_param("sssissii",
          $session_id, $kode_barang, $nama_barang, $jumlah,$tanggal,$jam,$harga,$satuan);
          

        $perintah->execute();

        if (!$perintah) 
        {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }
    } // end else 
    

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>