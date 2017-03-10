<?php session_start(); 

    include 'sanitasi.php';
    include 'db.php';
    $session_id = session_id();
    //mengirim data sesuai dengan variabel denagn metode POST 


    $kode_barang = stringdoang($_POST['kode_barang']);    
    $nama_barang = stringdoang($_POST['nama_barang']);
    $jumlah_barang = angkadoang($_POST['jumlah_barang']);
    $poin = angkadoang($_POST['poin']);
    $satuan = angkadoang($_POST['satuan']);
    $subtotal = angkadoang($_POST['subtotal']);
    $pelanggan = angkadoang($_POST['pelanggan']);


    $tanggal_sekarang = stringdoang($_POST['tanggal']);
    $jam_sekarang = date('H:i:s');
    $waktu = date('Y-m-d H:i:s');


            $perintah = $db->prepare("INSERT INTO tbs_tukar_poin(session_id, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu,pelanggan) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
            
            
            $perintah->bind_param("sssiiiisssi",
            $session_id, $kode_barang, $nama_barang, $satuan, $jumlah_barang, $poin, $subtotal, $tanggal_sekarang, $jam_sekarang,$waktu,$pelanggan);
            
            
            $perintah->execute();

                    // cek query
          if (!$perintah) 
          {
          die('Query Error : '.$db->errno.
          ' - '.$db->error);
          }
          


                ?>

   