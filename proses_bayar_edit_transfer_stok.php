<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = session_id();
    $tanggal_sekarang = date('Y-m-d');
    $jam_sekarang = date('H:i:s');
    $total = angkadoang($_POST['total']);
    $user = $_SESSION['nama'];
    $keterangan = stringdoang($_POST['keterangan']);
    $no_faktur = stringdoang($_POST['no_faktur']);


        
        // delete jurnal
        $delete_jurnal = $db->query("DELETE  FROM jurnal_trans WHERE no_faktur = '$no_faktur' AND jenis_transaksi = 'Transfer Stok' ");

          // delete detail
        $delete_detail = $db->query("DELETE  FROM detail_transfer_stok WHERE no_faktur = '$no_faktur' ");

        // update transfer stok
        
        $query_transfer_stok = $db->query("SELECT tanggal FROM transfer_stok WHERE no_faktur = '$no_faktur' ");
        $data_transfer_stok = mysqli_fetch_array($query_transfer_stok);
        $tanggal = $data_transfer_stok['tanggal'];

        $stmt = $db->prepare("UPDATE transfer_stok SET total = ?, keterangan = ?, user_edit = ?, tanggal_edit = ? WHERE no_faktur = ? ");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("issss", 
        $total, $keterangan,$user,$tanggal_sekarang,$no_faktur);    

  
  // jalankan query
        $stmt->execute();


// INSERT DETAIL TRANSFER STOK DARI TBS
    $query_tbs_transfer_stok = $db->query("SELECT * FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur'");
    while ($data_tbs_transfer_stok = mysqli_fetch_array($query_tbs_transfer_stok))
    {

       
        $query_detail_transfer_stok = "INSERT INTO detail_transfer_stok(no_faktur, tanggal, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, jam) 
        VALUES ('$no_faktur','$tanggal','$data_tbs_transfer_stok[kode_barang]','$data_tbs_transfer_stok[nama_barang]','$data_tbs_transfer_stok[kode_barang_tujuan]','$data_tbs_transfer_stok[nama_barang_tujuan]','$data_tbs_transfer_stok[jumlah]','$data_tbs_transfer_stok[satuan]','$data_tbs_transfer_stok[harga]','$data_tbs_transfer_stok[subtotal]','$data_tbs_transfer_stok[jam]')";


            if ($db->query($query_detail_transfer_stok) === TRUE) {
                
            } else {
            echo "Error: " . $query_detail_transfer_stok . "<br>" . $db->error;
            }


    }



// hpp  keluar
$sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil_sum_hpp_keluar = mysqli_fetch_array($sum_hpp_keluar);
$total_hpp_keluar = $ambil_sum_hpp_keluar['total'];

// hpp masuk 
$sum_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_masuk WHERE no_faktur = '$no_faktur'");
$ambil_sum_hpp_masuk = mysqli_fetch_array($sum_hpp_masuk);
$total_hpp_masuk = $ambil_sum_hpp_masuk['total'];

// setting akun
$select_setting_akun = $db->query("SELECT persediaan , item_keluar, item_masuk FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

    
    // jurnal masuk
              //PERSEDIAAN    
                $insert_jurnal_masuk1 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Transfer Stok - $keterangan', '$ambil_setting[persediaan]', '$total_hpp_masuk', '0', 'Transfer Stok', '$no_faktur','1', '$user')");

          //ITEM MASUK    
                $insert_jurnal_masuk2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Transfer Stok - $keterangan', '$ambil_setting[item_masuk]', '0', '$total_hpp_masuk', 'Transfer Stok', '$no_faktur','1', '$user')");

    // jurnal keluar
            //PERSEDIAAN    
                $insert_jurnal_keluar1 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Transfer Stok - $keterangan', '$ambil_setting[persediaan]', '0', '$total_hpp_keluar', 'Transfer Stok', '$no_faktur','1', '$user')");

                //ITEM KELUAR    
                $insert_jurnal_keluar2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) 
                  VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Transfer Stok - $keterangan', '$ambil_setting[item_keluar]', '$total_hpp_keluar', '0', 'Transfer Stok', '$no_faktur','1', '$user')");


  // INSERT HISTORY TBS TRANSFER STOK
  
  $query_insert_history_tbs_transfer_stok = $db->query("INSERT INTO history_edit_tbs_transfer_stok(no_faktur, session_id, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, tanggal, jam, waktu) 
  SELECT '$no_faktur', session_id, kode_barang, nama_barang, kode_barang_tujuan, nama_barang_tujuan, jumlah, satuan, harga, subtotal, tanggal, jam, waktu FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur' ");



    $query3 = $db->query("DELETE  FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur'");
    echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>