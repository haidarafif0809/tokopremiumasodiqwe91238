<?php session_start();
    // memasukan file yang ada pada db.php
include 'sanitasi.php';
include 'db.php';
include 'persediaan.function.php';

    // mengirim data sesuai variabel yang ada dengan menggunakan metode POST
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $satuan = stringdoang($_POST['satuan']);
    $jumlah_fisik = stringdoang($_POST['fisik']);
    
      $session_id = session_id();


        $query_update_barang = $db->prepare("UPDATE barang SET stok_opname = 'ya' WHERE kode_barang = ?");

        $query_update_barang->bind_param("s", $kode_barang);

        $query_update_barang->execute();


      $query_detail_pembelian = $db->query("SELECT SUM(jumlah_barang) AS masuk FROM detail_pembelian WHERE kode_barang = '$kode_barang'");
        $data_detail_pembelian = mysqli_fetch_array($query_detail_pembelian);
        $jumlah_masuk_pembelian = $data_detail_pembelian['masuk'];


        $query_detail_item_masuk = $db->query("SELECT SUM(jumlah) AS masuk FROM detail_item_masuk WHERE kode_barang = '$kode_barang'");
        $data_detail_item_masuk = mysqli_fetch_array($query_detail_item_masuk);
        $jumlah_masuk_item_masuk = $data_detail_item_masuk['masuk'];


        //hasil dari penjumlahan hasil masuk ini akan ditaruh ke kolom masuk (tbs_stok_opname)
        $hasil_masuk = $jumlah_masuk_pembelian + $jumlah_masuk_item_masuk;
        //hasil dari penjumlahan hasil masuk ini akan ditaruh ke kolom masuk (tbs_stok_opname)



      $query_detail_penjualan = $db->query("SELECT SUM(jumlah_barang) AS keluar FROM detail_penjualan WHERE kode_barang = '$kode_barang'");
        $data_detail_penjualan = mysqli_fetch_array($query_detail_penjualan);
        $jumlah_keluar_penjualan = $data_detail_penjualan['keluar'];


        $query_detail_item_keluar = $db->query("SELECT SUM(jumlah) AS keluar FROM detail_item_keluar WHERE kode_barang = '$kode_barang'");
        $data_detail_item_keluar = mysqli_fetch_array($query_detail_item_keluar);
        $jumlah_keluar_item_keluar = $data_detail_item_keluar['keluar'];

        //hasil dari penjumlahan hasil keluar ini akan ditaruh ke kolom keluar (tbs_stok_opname)
        $hasil_keluar = $jumlah_keluar_penjualan + $jumlah_keluar_item_keluar;
        //hasil dari penjumlahan hasil keluar ini akan ditaruh ke kolom keluar (tbs_stok_opname)

           
          //pengambilan stok barang dari hpp masuk - hpp keluar
            $stok_barang = cekStokHpp($kode_barang);
          //pengambilan stok barang dari hpp masuk - hpp keluar
           
            //perhitungan selisih fisik antara stok komputer dan fisik
           $jumlah_stok_komputer = $stok_barang;
            $selisih_fisik = $jumlah_fisik - $jumlah_stok_komputer;
            //perhitungan selisih fisik antara stok komputer dan fisik


    if ($selisih_fisik < 0) {//jika selisih nya kurang dari 0 harga ambil dari hppp masuk harga_unit

       // HARGA DARI HPP MASUK

       $pilih_hpp = $db->query("SELECT harga_unit FROM hpp_masuk WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
       $ambil_hpp = mysqli_fetch_array($pilih_hpp);
       $jumlah_hpp = $ambil_hpp['harga_unit'];


       // SAMPAI SINI

    } 

    else {//jika selisih nya lebih dari 0 harga ambil dari detail_pembelian / barang jika belum pernah ada pembelian

              // HARGA DARI DETAIL PEMBELIAN ATAU BARANG
        
        $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
        $num_rows = mysqli_num_rows($select2);
        $fetc_array = mysqli_fetch_array($select2);
        
        $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
        $ambil_barang = mysqli_fetch_array($select3);
        
        if ($num_rows == 0) {
         $jumlah_hpp = $ambil_barang['harga_beli'];
        } 
        
        else {
         $jumlah_hpp = $fetc_array['harga'];
        }
        
        // SAMPAI SINI
      }
    

        
     $selisih_harga = $jumlah_hpp * $selisih_fisik;      
        
        
        
        $cek = $db->query("SELECT jumlah_awal FROM stok_awal WHERE kode_barang = '$kode_barang' ");
        $data = mysqli_fetch_array($cek);
        $num = mysqli_num_rows($cek);

        if ($num > 0 ){
          $stok_awal = $data['jumlah_awal'];
        }
        else{
          $stok_awal = 0;
        }

        $query = "INSERT INTO tbs_stok_opname (session_id, kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) VALUES ('$session_id', '$kode_barang','$nama_barang','$satuan','$stok_awal','$hasil_masuk','$hasil_keluar','$jumlah_stok_komputer','$jumlah_fisik','$selisih_fisik','$selisih_harga','$jumlah_hpp','$jumlah_hpp')";      
        if ($db->query($query) === TRUE){

        }
        else
        {
            echo "Error: " . $query . "<br>" . $db->error;
        }
  
    ?>

