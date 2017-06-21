<?php session_start();
 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();
    $tanggal_sekarang = date("Y-m-d");
    $jam_sekarang = date("H:i:s");

    $kode_barang = stringdoang($_POST['kode_barang']);   
    $nama_barang = stringdoang($_POST['nama_barang']);
    $barang_tujuan = stringdoang($_POST['barang_tujuan']);   
    $nama_barang_tujuan = stringdoang($_POST['nama_barang_tujuan']);
    $satuan = stringdoang($_POST['satuan']);
    $jumlah = angkadoang($_POST['jumlah_barang']);
    $harga = angkadoang($_POST['harga']);
    $subtotal = $harga * $jumlah;

        if (isset($_POST['no_faktur'])) {
        
        $no_faktur = stringdoang($_POST['no_faktur']);

                    $perintah = $db->prepare("INSERT INTO tbs_transfer_stok(no_faktur, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, tanggal, jam) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

                    $perintah->bind_param("sssssiiiiss",
                      $no_faktur, $kode_barang, $nama_barang, $barang_tujuan, $nama_barang_tujuan, $jumlah, $satuan,$harga,$subtotal,$tanggal_sekarang,$jam_sekarang);
                    
                    
                    $perintah->execute();

                       if (!$perintah) {
                        die('Query Error : '.$db->errno.
                        ' - '.$db->error);
                        }
                        else {
                        
                        }


        }
        else{
                    $perintah = $db->prepare("INSERT INTO tbs_transfer_stok(session_id, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, tanggal, jam) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

                    $perintah->bind_param("sssssiiiiss",
                      $session_id, $kode_barang, $nama_barang, $barang_tujuan, $nama_barang_tujuan, $jumlah, $satuan,$harga,$subtotal,$tanggal_sekarang,$jam_sekarang);
                    
                    
                    $perintah->execute();

                       if (!$perintah) {
                        die('Query Error : '.$db->errno.
                        ' - '.$db->error);
                        }
                        else {
                        
                        }
        }






    ?>
