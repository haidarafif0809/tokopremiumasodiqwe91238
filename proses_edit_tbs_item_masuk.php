<?php 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';


    $no_faktur = stringdoang($_POST['no_faktur']);
    $kode_barang = stringdoang($_POST['kode_barang']);   
    



        $hpp_item_masuk = angkadoang($_POST['hpp_item_masuk']);

      if ($hpp_item_masuk == "") 
      {
        $perintah = $db->prepare("INSERT INTO tbs_item_masuk (no_faktur,kode_barang,nama_barang,jumlah,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisii",
          $no_faktur, $kode_barang, $nama_barang, $jumlah, $satuan, $harga, $subtotal);
        
        $no_faktur = stringdoang($_POST['no_faktur']);
        $nama_barang = stringdoang($_POST['nama_barang']);
        $satuan = stringdoang($_POST['satuan']);
        $harga = angkadoang($_POST['harga']);
        $jumlah = angkadoang($_POST['jumlah_barang']);
        $kode_barang = stringdoang($_POST['kode_barang']);
        $subtotal = $harga * $jumlah;


        
        $perintah->execute();

      }

      else 
      {
        $perintah = $db->prepare("INSERT INTO tbs_item_masuk (no_faktur,kode_barang,nama_barang,jumlah,satuan,harga,subtotal) VALUES (?,?,?,?,?,?,?)");

        $perintah->bind_param("sssisii",
          $no_faktur, $kode_barang, $nama_barang, $jumlah, $satuan, $hpp_item_masuk, $subtotal);
        
        $no_faktur = stringdoang($_POST['no_faktur']);
        $nama_barang = stringdoang($_POST['nama_barang']);
        $satuan = stringdoang($_POST['satuan']);
        $hpp_item_masuk = angkadoang($_POST['hpp_item_masuk']);
        $jumlah = angkadoang($_POST['jumlah_barang']);
        $kode_barang = stringdoang($_POST['kode_barang']);
        $subtotal = $hpp_item_masuk * $jumlah;


        
        $perintah->execute();

      }



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
