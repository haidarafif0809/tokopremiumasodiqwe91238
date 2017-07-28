<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $nomor_faktur = stringdoang($_POST['no_faktur']);
    
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);
$tanggal = stringdoang($_POST['tanggal']);
$waktu = $tanggal." ".$jam_sekarang;

$id_pelanggan = stringdoang($_POST['real_id']);

$kode_send = stringdoang($_POST['kode_pelanggan']);

$select_kode_pelanggan = $db->query("SELECT kode_pelanggan,nama_pelanggan FROM pelanggan WHERE id = '$id_pelanggan'");
$ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);
 $kode_pelanggan = $ambil_kode_pelanggan['kode_pelanggan'];

            $sisa = stringdoang($_POST['sisa']);
            $sisa = str_replace(',','.',$sisa);
             if ($sisa == '') {
                $sisa = 0;
              }

            $sisa_kredit = stringdoang($_POST['jumlah_kredit_baru']);
             $sisa_kredit = str_replace(',','.',$sisa_kredit);
             if ($sisa_kredit == '') {
                $sisa_kredit = 0;
              }


            $delete_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE no_faktur = '$nomor_faktur' ");
            $delete_detail_penjualan = $db->query("DELETE FROM bonus_penjualan WHERE no_faktur_penjualan = '$nomor_faktur' ");

            $query12 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur' ");
            while ($data = mysqli_fetch_array($query12)){
  

                $pilih_konversi = $db->query("SELECT COUNT(sk.konversi) AS jumlah_data,sk.konversi, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.kode_produk = b.kode_barang AND sk.id_produk = b.id WHERE sk.kode_produk = '$data[kode_barang]' AND sk.id_satuan = '$data[satuan]'");
                $data_konversi = mysqli_fetch_array($pilih_konversi);
                
                if ($data_konversi['jumlah_data'] != 0) {
                
                $harga_konversi = $data['harga_konversi'];
                $jumlah_barang = $data['jumlah_barang'] * $data_konversi['konversi'];
                $satuan = $data['satuan'];
                
                }
                else{
                
                $harga_konversi = 0;
                $jumlah_barang = $data['jumlah_barang'];
                $satuan = $data['satuan'];
                }

               $query2 = "INSERT INTO detail_penjualan (no_faktur, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa,harga_konversi)
               VALUES ('$data[no_faktur]', '$tanggal','$jam_sekarang', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_barang', '$satuan','$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$jumlah_barang','$harga_konversi')";

                       if ($db->query($query2) === TRUE) {
                       } 
                       
                       else {
                       echo "Error: " . $query2 . "<br>" . $db->error;
                       }
        

            }//end while

            if ($sisa_kredit == 0 ) 
            
            {
                echo "1";
            
            // buat prepared statements
            $stmt2 = $db->prepare("UPDATE penjualan SET no_faktur = ?, kode_gudang = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, user = ?, sales = ?, status = 'Lunas', potongan = ?, tax = ?, sisa = ?, kredit='0', cara_bayar = ?, tunai = ?, status_jual_awal = 'Tunai', ppn = ?, biaya_admin = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("ssssssssssssssss", 
            $nomor_faktur, $kode_gudang, $id_pelanggan, $total, $tanggal, $jam_sekarang , $user, $sales, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $ppn_input, $biaya_adm, $nomor_faktur);

            
            // siapkan "data" query
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            
            $total = stringdoang($_POST['total']);
            $total = str_replace(',','.',$total);
             if ($total == '') {
                $total = 0;
              }
            $total2 = stringdoang($_POST['total2']);
             $total2 = str_replace(',','.',$total2);
             if ($total2 == '') {
                $total2 = 0;
              }
            $potongan = stringdoang($_POST['potongan']);
             $potongan = str_replace(',','.',$potongan);
             if ($potongan == '') {
                $potongan = 0;
              }
            $tax = stringdoang($_POST['tax']);
            $tax = str_replace(',','.',$tax);
             if ($tax == '') {
                $tax = 0;
              }
            $ppn_input = stringdoang($_POST['ppn_input']);
            $biaya_adm = stringdoang($_POST['biaya_adm']);
               $biaya_adm = str_replace(',','.',$biaya_adm);
             if ($biaya_adm == '') {
                $biaya_adm = 0;
              }
            $sisa_pembayaran = stringdoang($_POST['sisa_pembayaran']);
             $sisa_pembayaran = str_replace(',','.',$sisa_pembayaran);
             if ($sisa_pembayaran == '') {
                $sisa_pembayaran = 0;
              }

            $x = stringdoang($_POST['x']);
            
            if ($x <= $total) {
            $sisa = 0;
            } 
            
            else {
            $sisa = $x - $total;
            }

            
            $cara_bayar = stringdoang($_POST['cara_bayar']);
            $pembayaran = stringdoang($_POST['pembayaran']);
            $pembayaran = str_replace(',','.',$pembayaran);              
              if ($pembayaran == '') {
                $pembayaran = 0;
              }

            $sales = stringdoang($_POST['sales']);
            $user = $_SESSION['user_name'];
            $tanggal = stringdoang($_POST['tanggal']);
            $kode_gudang = stringdoang($_POST['kode_gudang']);
            
            // jalankan query
            
            $stmt2->execute();         
 }

            

            else if ($sisa_kredit != 0 ) 

            {
            echo "2";
            $stmt2 = $db->prepare("UPDATE penjualan SET no_faktur = ?,  kode_gudang = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, tanggal_jt = ?, user = ?, sales = ?, status = 'Piutang', potongan = ?, tax = ?, sisa = '0', kredit = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Kredit', ppn = ?, biaya_admin = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("sssssssssssssssss", 
            $nomor_faktur, $kode_gudang, $id_pelanggan, $total , $tanggal, $jam_sekarang, $tanggal_jt, $user, $sales, $potongan, $tax, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input, $biaya_adm, $nomor_faktur);
            
            // siapkan "data" query
            $biaya_adm = stringdoang($_POST['biaya_adm']);
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            
            $total = stringdoang($_POST['total']);
            $total = str_replace(',','.',$total);
             if ($total == '') {
                $total = 0;
              }
            $total2 = stringdoang($_POST['total2']);
            $total2 = str_replace(',','.',$total2);
             if ($total2 == '') {
                $total2 = 0;
              }
            $potongan = stringdoang($_POST['potongan']);
            $potongan = str_replace(',','.',$potongan);
             if ($potongan == '') {
                $potongan = 0;
              }
            $tax = stringdoang($_POST['tax']);
            $tax = str_replace(',','.',$tax);
             if ($tax == '') {
                $tax = 0;
              }   
            $ppn_input = stringdoang($_POST['ppn_input']);
            $tanggal_jt = stringdoang($_POST['tanggal_jt']);
            $sisa_pembayaran = stringdoang($_POST['sisa_pembayaran']);
            $sisa_pembayaran = str_replace(',','.',$sisa_pembayaran);
             if ($sisa_pembayaran == '') {
                $sisa_pembayaran = 0;
              }
            $sisa_kredit = stringdoang($_POST['jumlah_kredit_baru']);
            $sisa_kredit = str_replace(',','.',$sisa_kredit);
             if ($sisa_kredit == '') {
                $sisa_kredit = 0;
              }
            $pembayaran = stringdoang($_POST['pembayaran']);
            $pembayaran = str_replace(',','.',$pembayaran);
             if ($pembayaran == '') {
                $pembayaran = 0;
              }
            $sales = stringdoang($_POST['sales']);
            $cara_bayar = stringdoang($_POST['cara_bayar']);
            $tanggal = stringdoang($_POST['tanggal']);
            $kode_gudang = stringdoang($_POST['kode_gudang']);
            
            $user = $_SESSION['user_name'];
            
            // jalankan query
            $stmt2->execute(); 
            
}

  // coding untuk memasukan history_tbs dan menghapus tbs
    $tbs_penjualan_masuk = "INSERT INTO history_edit_tbs_penjualan (no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,harga_konversi) 
    SELECT no_faktur,kode_barang,nama_barang,jumlah_barang,satuan,harga,subtotal,potongan,tax,harga_konversi FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur' ";
        if ($db->query($tbs_penjualan_masuk) === TRUE) {
              
        }
        else{
            echo "Error: " . $tbs_penjualan_masuk . "<br>" . $db->error;
        }


  $perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");

        //awal nya bonus
    $query_tbs_bonus_penjualan = $db->query("SELECT tp.kode_produk,tp.nama_produk,tp.qty_bonus,tp.keterangan,tp.tanggal,tp.jam,b.id as baranga,tp.satuan,tp.harga_disc FROM tbs_bonus_penjualan tp LEFT JOIN barang b ON tp.kode_produk = b.kode_barang WHERE tp.no_faktur_penjualan = '$nomor_faktur'");
    while($datatb = mysqli_fetch_array($query_tbs_bonus_penjualan)){

        //LOGIKA KETIKA ADA PRODUK PARCEL YANG AKAN DIJUAL, KARENA PARCEL TIDAK MASUK KE DALAM PRODUK BONUS
        $query_cek_produk = $db->query("SELECT COUNT(kode_barang) FROM barang WHERE kode_barang = '$datatb[kode_produk]'");
        $jumlah_cek_produk = mysqli_num_rows($query_cek_produk);
          
          if ($jumlah_cek_produk > 0 ) {

              $subtotal_bonusnya = $datatb['qty_bonus'] * $datatb['harga_disc'];

              $query_insert_bonus_penjualan = "INSERT INTO bonus_penjualan (no_faktur_penjualan, kode_pelanggan, tanggal, jam, kode_produk, nama_produk, qty_bonus,keterangan,harga_disc,subtotal,satuan) VALUES ('$no_faktur', '$id_pelanggan', '$datatb[tanggal]', '$datatb[jam]', '$datatb[kode_produk]', '$datatb[nama_produk]', '$datatb[qty_bonus]', '$datatb[keterangan]', '$datatb[harga_disc]' ,'$subtotal_bonusnya','$datatb[satuan]' )";

                if ($db->query($query_insert_bonus_penjualan) === TRUE) {
                } 

                else {
                echo "Error: " . $query_insert_bonus_penjualan . "<br>" . $db->error;
                }



                // MENGAUPDATE KETERANGAN_PROMO_DISC DI TABLE PENJAUALAN 
                $update_jual = "UPDATE penjualan SET keterangan_promo_disc = '$datatb[keterangan]' WHERE no_faktur = '$nomor_faktur'";
                    if ($db->query($update_jual) === TRUE) {
                    } 

                    else {
                    echo "Error: " . $update_jual . "<br>" . $db->error;
                    }

          }
      }// end while
//end nya bonus
  $query_delete_tbs_penjualan = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
  $query_delete_tbs_bonus_penjualan = $db->query("DELETE  FROM tbs_bonus_penjualan WHERE no_faktur = '$nomor_faktur'");

 echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>