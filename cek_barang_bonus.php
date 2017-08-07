<?php session_start();
    // memasukan file yang ada pada db.php
    include 'db.php';
    include 'sanitasi.php';
    include 'persediaan.function.php';

    $session_id = session_id();
    $tanggal = date('Y-m-d');
    $jam = date('H:i:s');

    //Barang Yang di Kirimkan
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $program = stringdoang($_POST['program']);
    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $harga_jual_bonus = angkadoang($_POST['harga_jual_bonus']);
    $harga_awal = angkadoang($_POST['harga_awal']);
    $satuan = stringdoang($_POST['satuan']);
    $keterangan = stringdoang($_POST['keterangan']);

    $subtotal = $harga_jual_bonus * $jumlah_barang;

    //Cek Stok Barang di HPP
    $stok_barang = cekStokHpp($kode_barang);

 	$persedian_barang = $stok_barang - $jumlah_barang;

    if ($persedian_barang < 0) {
       echo 1; // Jumlah Barang Tidak Mencukupi !!
    }
    else{

        $query_insert_tbs_bonus_penjualan = $db->prepare("INSERT INTO tbs_bonus_penjualan (session_id,kode_produk,nama_produk,qty_bonus,keterangan,tanggal,jam,satuan,harga_disc,subtotal) VALUES (?,?,?,?,?,?,?,?,?,?)");

        $query_insert_tbs_bonus_penjualan->bind_param("sssisssiii",
          $session_id, $kode_barang, $nama_barang, $jumlah_barang,$keterangan,$tanggal,$jam,$satuan,$harga_jual_bonus,$subtotal);
          
        $query_insert_tbs_bonus_penjualan->execute();

        if (!$query_insert_tbs_bonus_penjualan){
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }
    }
    
?>