<?php 
    // memasukan file yang ada pada db.php
include 'sanitasi.php';
include 'db.php';
    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $satuan = angkadoang($_POST['satuan']);
    $jumlah_fisik = angkadoang($_POST['fisik']);
    $jumlah_stok_komputer = angkadoang($_POST['jumlah_stok_komputer']);
    $jumlah_hpp_minus = angkadoang($_POST['jumlah_hpp_minus']);
    $jumlah_hpp_plus = angkadoang($_POST['jumlah_hpp_plus']);
    

        $query9 = $db->prepare("UPDATE barang SET stok_opname = 'ya' WHERE kode_barang = ?");

        $query9->bind_param("s", $kode_barang);

        $query9->execute();


        $query1 = $db->query("SELECT SUM(jumlah_barang) AS masuk FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $hasil1 = mysqli_fetch_array($query1);
        $jumlah_masuk_pembelian = $hasil1['masuk'];


        $query3 = $db->query("SELECT SUM(jumlah) AS masuk FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
        $hasil2 = mysqli_fetch_array($query3);
        $jumlah_masuk_item_masuk = $hasil2['masuk'];



        $hasil_masuk = $jumlah_masuk_pembelian + $jumlah_masuk_item_masuk;



        $query4 = $db->query("SELECT SUM(jumlah_barang) AS keluar FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
        $hasil3 = mysqli_fetch_array($query4);
        $jumlah_keluar_penjualan = $hasil3['keluar'];


        $query5 = $db->query("SELECT SUM(jumlah) AS keluar FROM detail_item_keluar WHERE kode_barang = '$kode_barang'");
        $hasil4 = mysqli_fetch_array($query5);
        $jumlah_keluar_item_keluar = $hasil4['keluar'];

        $hasil_keluar = $jumlah_keluar_penjualan + $jumlah_keluar_item_keluar;
                  
        $selisih_fisik = $jumlah_fisik - $jumlah_stok_komputer;

        if ($selisih_fisik < 0) {
          $jumlah_hpp = $jumlah_hpp_minus;
        $selisih_harga = $jumlah_hpp_minus * $selisih_fisik;    
        
        } 
        
        else {

          $jumlah_hpp = $jumlah_hpp_plus;
          $selisih_harga = $jumlah_hpp_plus * $selisih_fisik;    
        }


        $cek = $db->query("SELECT * FROM stok_awal WHERE kode_barang = '$kode_barang' ");
        $data = mysqli_fetch_array($cek);
        $stok_awal = $data['jumlah_awal'];
        
        
        $query = "INSERT INTO tbs_stok_opname (kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) 
        VALUES ('$kode_barang','$nama_barang','$satuan','$stok_awal','$hasil_masuk','$hasil_keluar','$jumlah_stok_komputer','$jumlah_fisik','$selisih_fisik','$selisih_harga','$jumlah_hpp','$jumlah_hpp')";
        
        if ($db->query($query) === TRUE)
        {

        }
        else
        {
            echo "Error: " . $query . "<br>" . $db->error;
        }
             
    
                  mysqli_close($db);   
                  ?>