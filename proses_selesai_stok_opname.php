<?php session_start();

        include 'sanitasi.php';
        include 'db.php';
        include 'persediaan.function.php';

        $tahun_sekarang = date('Y');
        $bulan_sekarang = date('m');
        $tanggal_sekarang = date('Y-m-d');
        $jam_sekarang = date('H:i:s');
        $tahun_terakhir = substr($tahun_sekarang, 2);

        $session_id = session_id();

                //ambil 2 angka terakhir dari tahun sekarang 
                  $tahun = $db->query("SELECT YEAR(NOW()) as tahun");
                  $v_tahun = mysqli_fetch_array($tahun);
                  $tahun_terakhir = substr($v_tahun['tahun'], 2);
                  //ambil bulan sekarang
                  $bulan = $db->query("SELECT MONTH(NOW()) as bulan");
                  $v_bulan = mysqli_fetch_array($bulan);
                  $v_bulan['bulan'];
                  
                  
                  //mengecek jumlah karakter dari bulan sekarang
                  $cek_jumlah_bulan = strlen($v_bulan['bulan']);
                  
                  //jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
                  if ($cek_jumlah_bulan == 1) {
                  # code...
                  $data_bulan_terakhir = "0".$v_bulan['bulan'];
                  }
                  else
                  {
                  $data_bulan_terakhir = $v_bulan['bulan'];
                  
                  }
                  //ambil bulan dari tanggal stok_opname terakhir
                  
                  $bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM stok_opname ORDER BY id DESC LIMIT 1");
                  $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);
                  
                  //ambil nomor  dari stok_opname terakhir
                  $no_terakhir = $db->query("SELECT no_faktur FROM stok_opname ORDER BY id DESC LIMIT 1");
                  $v_no_terakhir = mysqli_fetch_array($no_terakhir);
                  $ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);
                  
                  /*jika bulan terakhir dari stok_opname tidak sama dengan bulan sekarang, 
                  maka nomor nya kembali mulai dari 1 ,
                  jika tidak maka nomor terakhir ditambah dengan 1
                  
                  */
                  if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
                  # code...
                  $no_faktur = "1/SO/".$data_bulan_terakhir."/".$tahun_terakhir;
                  
                  }
                  
                  else
                  {
                  
                  $nomor = 1 + $ambil_nomor ;
                  
                  $no_faktur = $nomor."/SO/".$data_bulan_terakhir."/".$tahun_terakhir;
                  
                  
                  }
                //end pembuatan no faktur

              //STARTING MASUKIN KE HISTORY TBSNYA
              $queryhtso = "INSERT INTO history_tbs_stok_opname(session_id, no_faktur, kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) SELECT session_id, no_faktur, kode_barang, nama_barang, satuan, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp FROM tbs_stok_opname WHERE no_faktur = '' OR no_faktur IS NULL";
            
                if ($db->query($queryhtso) === TRUE) {
                
                } else {
                echo "Error: " . $queryhtso . "<br>" . $db->error;
                }
              //ENDING MASUKIN KE HISTORY TBSNYA 


        $query_tbs_stok_opname = $db->query("SELECT * FROM tbs_stok_opname WHERE no_faktur = '' OR no_faktur IS NULL ");
        while ($data = mysqli_fetch_array($query_tbs_stok_opname))
        {


            //pengambilan stok barang dari hpp masuk - hpp keluar
            $stok_barang = cekStokHpp($data['kode_barang']);
            //pengambilan stok barang dari hpp masuk - hpp keluar
           
            //perhitungan selisih fisik antara stok komputer dan fisik
           $jumlah_stok_komputer = $stok_barang;
            $selisih_fisik = $data['fisik'] - $jumlah_stok_komputer;
            //perhitungan selisih fisik antara stok komputer dan fisik


        if ($selisih_fisik < 0) {//jika selisih nya kurang dari 0 harga ambil dari hppp masuk harga_unit

        // HARGA DARI HPP MASUK
       $pilih_hpp = $db->query("SELECT harga_unit FROM hpp_masuk WHERE kode_barang = '$data[kode_barang]' ORDER BY id DESC LIMIT 1");
       $ambil_hpp = mysqli_fetch_array($pilih_hpp);
       $jumlah_hpp = $ambil_hpp['harga_unit'];
       // SAMPAI SINI
        } 

        else {//jika selisih nya lebih dari 0 harga ambil dari detail_pembelian / barang jika belum pernah ada pembelian

              // HARGA DARI DETAIL PEMBELIAN ATAU BARANG
        
        $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$data[kode_barang]' ORDER BY id DESC LIMIT 1");
        $num_rows = mysqli_num_rows($select2);
        $fetc_array = mysqli_fetch_array($select2);
        
        $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$data[kode_barang]' ORDER BY id DESC LIMIT 1");
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
        


            
            $query = $db->query("UPDATE barang SET stok_opname = '' WHERE kode_barang = '$data[kode_barang]'");

          $query4 = "INSERT INTO detail_stok_opname (no_faktur, tanggal, jam, kode_barang, nama_barang, awal, masuk, keluar, stok_sekarang, fisik, selisih_fisik, selisih_harga, harga, hpp) 
          VALUES ('$no_faktur', '$tanggal_sekarang', '$jam_sekarang', '$data[kode_barang]', '$data[nama_barang]', '$data[awal]', '$data[masuk]', '$data[keluar]', '$data[stok_sekarang]', '$data[fisik]', '$data[selisih_fisik]', '$selisih_harga', '$jumlah_hpp', '$jumlah_hpp')";
            
            if ($db->query($query4) === TRUE) {
                
            } else {
            echo "Error: " . $query4 . "<br>" . $db->error;
            }
            
            
        
        }//en while masukan data detail stok opname


            // menampilakn hasil penjumlahan subtotal dengan ALIAS total pembelian, pada tabel tbs pembelian
            // berdasarkan no faktur
            $query_detail_stok_opname = $db->query("SELECT SUM(selisih_harga) AS total_selisih_harga FROM detail_stok_opname WHERE no_faktur = '$no_faktur' ");

            // menyimpan data sementara pada $query
            $data_detail_stok_opname = mysqli_fetch_array($query_detail_stok_opname);

            // menampilkan file atau isi dari data_detail_stok_opname total pembelian
            


                $query2 = $db->prepare("INSERT INTO stok_opname (no_faktur,tanggal,jam,status, total_selisih,user) 
                VALUES (?,?,?,'ya',?,?)");
                
                $query2->bind_param("sssis",
                $no_faktur,$tanggal_sekarang,$jam_sekarang,$data_detail_stok_opname['total_selisih_harga'],$user);
                
                $total_selisih_harga = $data_detail_stok_opname['total_selisih_harga'];
                $selisih_harga = $total_selisih_harga;
                $user = $_SESSION['user_name'];
                
                $query2->execute();



              $sum_hpp_keluar = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
              $ambil_sum = mysqli_fetch_array($sum_hpp_keluar);
              $total = $ambil_sum['total'];


              $sum_hpp_masuk = $db->query("SELECT SUM(total_nilai) AS total FROM hpp_masuk WHERE no_faktur = '$no_faktur'");
              $ambil_sum_masuk = mysqli_fetch_array($sum_hpp_keluar);
              $total_masuk = $ambil_sum_masuk['total'];

              $select_setting_akun = $db->query("SELECT pengaturan_stok,persediaan  FROM setting_akun");
              $ambil_setting = mysqli_fetch_array($select_setting_akun);

             if ($data_detail_stok_opname['total_selisih_harga'] < 0) {
                $total0 = $total;

               //PERSEDIAAN    
             $insert_jurnal = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '0', '$total0', 'Stok Opname', '$no_faktur','1', '$user')";
              if ($db->query($insert_jurnal) === TRUE) {
                
               } else {
                echo "Error: " . $insert_jurnal . "<br>" . $db->error;
                }



              //STOK OPNAME    
              $insert_jurnal2 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '$total0', '0', 'Stok Opname', '$no_faktur','1', '$user')";
              if ($db->query($insert_jurnal2) === TRUE) {
                
               } else {
              echo "Error: " . $insert_jurnal2 . "<br>" . $db->error;
              }
            } //penutup if ($data['total_selisih_harga'] < 0) {


      else {

       $total_tbs = $total_masuk;

        //PERSEDIAAN    
        $insert_jurnal3 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[persediaan]', '$data_detail_stok_opname[total_selisih_harga]', '0', 'Stok Opname', '$no_faktur','1', '$user')";
        
        if ($db->query($insert_jurnal3) === TRUE) {
                
            } else {
            echo "Error: " . $insert_jurnal3 . "<br>" . $db->error;
            }

        //STOK OPNAME    
        $insert_jurnal4 = "INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Stok Opname -', '$ambil_setting[pengaturan_stok]', '0', '$data_detail_stok_opname[total_selisih_harga]', 'Stok Opname', '$no_faktur','1', '$user')";
        if ($db->query($insert_jurnal4) === TRUE) {
                
            } else {
            echo "Error: " . $insert_jurnal4 . "<br>" . $db->error;
            }
        
        }



 $query5 = $db->query("DELETE FROM tbs_stok_opname WHERE no_faktur = '' OR no_faktur IS NULL  ");
        
        
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>