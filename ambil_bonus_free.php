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
    $jumlahnya = angkadoang($_POST['jumlah']);
    $satuan = angkadoang($_POST['satuan']);
    $harga_disc = angkadoang($_POST['harga_disc']);
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');
    
    $persediaankurang = $jumlahnya - $stok;
    //jika persediaan > jumlahnya yang di ambil maka 
    if ($persediaankurang < 0) {
        $jumlah = $jumlahnya;
    }
    else{
        $jumlah = $stok;
    }

    $hasil = $stok - $jumlahnya;
    //cek stok barang, jika barang masih ada maka akan masuk,
    if ($hasil < 0 ) {
        echo 1;
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
    }//end else
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>