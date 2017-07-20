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

            $query12 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur' ");
            while ($data = mysqli_fetch_array($query12))
            
            {
  

                $pilih_konversi = $db->query("SELECT COUNT(sk.konversi) AS jumlah_data,sk.konversi, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.kode_produk = b.kode_barang AND sk.id_produk = b.id WHERE sk.kode_produk = '$data[kode_barang]' AND sk.id_satuan = '$data[satuan]'");
                $data_konversi = mysqli_fetch_array($pilih_konversi);
                
                if ($data_konversi['jumlah_data'] != 0) {
                
                $harga = $data['harga'] / $data_konversi['konversi'];
                $jumlah_barang = $data['jumlah_barang'] * $data_konversi['konversi'];
                $satuan = $data['satuan'];
                
                }
                else{
                
                $harga = $data['harga'];
                $jumlah_barang = $data['jumlah_barang'];
                $satuan = $data['satuan'];
                }

               $query2 = "INSERT INTO detail_penjualan (no_faktur, tanggal, jam, kode_barang, nama_barang, jumlah_barang, asal_satuan,satuan, harga, subtotal, potongan, tax, sisa)
               VALUES ('$data[no_faktur]', '$tanggal','$jam_sekarang', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_barang', '$satuan','$data[satuan]', '$harga', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$jumlah_barang')";

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

  $perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");

 echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>