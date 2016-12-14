<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $nomor_faktur = stringdoang($_POST['no_faktur']);
    
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$tanggal = stringdoang($_POST['tanggal']);
$waktu = $tanggal." ".$jam_sekarang;


$kode_pelanggan = stringdoang($_POST['kode_pelanggan']);

$select_kode_pelanggan = $db->query("SELECT id,nama_pelanggan FROM pelanggan WHERE id = '$kode_pelanggan'");
$ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);
            
            $sisa = angkadoang($_POST['sisa']);
            $sisa_kredit = angkadoang($_POST['jumlah_kredit_baru']);



            $query12 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur' ");
            while ($data = mysqli_fetch_array($query12))
            
            {

            $select_hpp_keluar = $db->query("SELECT * FROM hpp_keluar WHERE no_faktur = '$nomor_faktur' AND kode_barang = '$data[kode_barang]' AND sisa_barang != jumlah_kuantitas ");
            $row_hpp_keluar = mysqli_num_rows($select_hpp_keluar);

            if ($row_hpp_keluar == 0) {

                $delete_detail_penjualan = $db->query("DELETE FROM detail_penjualan WHERE no_faktur = '$nomor_faktur' AND kode_barang = '$data[kode_barang]'");
            
            $pilih_konversi = $db->query("SELECT  sk.konversi * $data[jumlah_barang] AS jumlah_konversi, $data[harga] * $data[jumlah_barang] / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data[satuan]' AND kode_produk = '$data[kode_barang]'");
            $data_konversi = mysqli_fetch_array($pilih_konversi);
            
            if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
            $harga = $data_konversi['harga_konversi'];
            $jumlah_barang = $data_konversi['jumlah_konversi'];
            $satuan = $data_konversi['satuan'];
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
                       
            } 

            else {
                
            }
            
            
    

            }

            if ($sisa_kredit == 0 ) 
            
            {
                echo "1";
            
            // buat prepared statements
            $stmt2 = $db->prepare("UPDATE penjualan SET no_faktur = ?, kode_gudang = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, user = ?, sales = ?, status = 'Lunas', potongan = ?, tax = ?, sisa = ?, kredit='0', cara_bayar = ?, tunai = ?, status_jual_awal = 'Tunai', ppn = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("sssissssiiisiss", 
            $nomor_faktur, $kode_gudang, $kode_pelanggan, $total, $tanggal, $jam_sekarang , $user, $sales, $potongan, $tax, $sisa, $cara_bayar, $pembayaran, $ppn_input, $nomor_faktur);

            
            // siapkan "data" query
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
            $total = angkadoang($_POST['total']);
            $total2 = angkadoang($_POST['total2']);
            $potongan = angkadoang($_POST['potongan']);
            $tax = angkadoang($_POST['tax']);
            $ppn_input = stringdoang($_POST['ppn_input']);
            $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
            
            $x = angkadoang($_POST['x']);
            
            if ($x <= $total) {
            $sisa = 0;
            } 
            
            else {
            $sisa = $x - $total;
            }
            
            $cara_bayar = stringdoang($_POST['cara_bayar']);
            $pembayaran = angkadoang($_POST['pembayaran']);
            $sales = stringdoang($_POST['sales']);
            $user = $_SESSION['user_name'];
            $tanggal = stringdoang($_POST['tanggal']);
            $kode_gudang = stringdoang($_POST['kode_gudang']);
            
            // jalankan query
            
            $stmt2->execute();    


$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$nomor_faktur'");
$ambil = mysqli_fetch_array($select);
$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);



//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$nomor_faktur','1', '$user')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$nomor_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total', '0', 'Penjualan', '$nomor_faktur','1', '$user')");



if ($ppn_input == "Non") {

    $total_penjualan = $total2;

echo $ppn_input;
  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
echo $ppn_input;
  $total_penjualan = $total2 - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
      }
      

  }

else {
  //ppn == Exclude
  $total_penjualan = $total2;
  $pajak = $tax;
echo $ppn_input;
 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
}

}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$nomor_faktur','1', '$user')");
}

            
              
 }

            

            else if ($sisa_kredit != 0 ) 

            {
            echo "2";
            $stmt2 = $db->prepare("UPDATE penjualan SET no_faktur = ?,  kode_gudang = ?, kode_pelanggan = ?, total = ?, tanggal = ?, jam = ?, tanggal_jt = ?, user = ?, sales = ?, status = 'Piutang', potongan = ?, tax = ?, sisa = '0', kredit = ?, cara_bayar = ?, tunai = ?, status_jual_awal = 'Kredit', ppn = ? WHERE no_faktur = ?");
            
            
            // hubungkan "data" dengan prepared statements
            $stmt2->bind_param("sssisssssiiisiss", 
            $nomor_faktur, $kode_gudang, $kode_pelanggan, $total , $tanggal, $jam_sekarang, $tanggal_jt, $user, $sales, $potongan, $tax, $sisa_kredit, $cara_bayar, $pembayaran, $ppn_input, $nomor_faktur);
            
            // siapkan "data" query
            $nomor_faktur = stringdoang($_POST['no_faktur']);
            $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
            $total = angkadoang($_POST['total']);
            $total2 = angkadoang($_POST['total2']);
            $potongan = angkadoang($_POST['potongan']);
            $tax = angkadoang($_POST['tax']);
            $ppn_input = stringdoang($_POST['ppn_input']);
            $tanggal_jt = angkadoang($_POST['tanggal_jt']);
            $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
            $sisa_kredit = angkadoang($_POST['jumlah_kredit_baru']);
            $pembayaran = angkadoang($_POST['pembayaran']);
            $sales = stringdoang($_POST['sales']);
            $cara_bayar = stringdoang($_POST['cara_bayar']);
            $tanggal = stringdoang($_POST['tanggal']);
            $kode_gudang = stringdoang($_POST['kode_gudang']);
            
            $user = $_SESSION['user_name'];
            
            // jalankan query
            $stmt2->execute(); 
            


              
$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$nomor_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


$sum_tax_tbs = $db->query("SELECT SUM(tax) AS total_tax FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");
$jumlah_tax = mysqli_fetch_array($sum_tax_tbs);
$total_tax = $jumlah_tax['total_tax'];

    $ppn_input = stringdoang($_POST['ppn_input']);
    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);



//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[persediaan]', '0', '$total_hpp', 'Penjualan', '$nomor_faktur','1', '$user')");
        

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$nomor_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$pembayaran', '0', 'Penjualan', '$nomor_faktur','1', '$user')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '$sisa_kredit', '0', 'Penjualan', '$nomor_faktur','1', '$user')");


if ($ppn_input == "Non") {

    $total_penjualan = $total2;

echo $ppn_input;
  //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

} 


else if ($ppn_input == "Include") {
//ppn == Include
echo $ppn_input;
  $total_penjualan = $total2 - $total_tax;
  $pajak = $total_tax;

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");

if ($pajak != "" || $pajak != 0) {
  //PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
}

  }

else {
  //ppn == Exclude
  $total_penjualan = $total2;
  $pajak = $tax;
echo $ppn_input;
 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[total_penjualan]', '0', '$total_penjualan', 'Penjualan', '$nomor_faktur','1', '$user')");


if ($pajak != "" || $pajak != 0) {
//PAJAK
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pajak_jual]', '0', '$pajak', 'Penjualan', '$nomor_faktur','1', '$user')");
}


}


if ($potongan != "" || $potongan != 0 ) {
//POTONGAN
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_jual]', '$potongan', '0', 'Penjualan', '$nomor_faktur','1', '$user')");
}


   
}


    // cek query
if (!$stmt2) 
      {
        die('Query Error : '.$db->errno.
          ' - '.$db->error);
      }

else 
      {
    
      }
            
            
            
            

       
// BOT STAR AUTO      

              $total = angkadoang($_POST['total']);

                    
      $url = "https://api.telegram.org/bot233675698:AAEbTKDcPH446F-bje4XIf1YJ0kcmoUGffA/sendMessage?chat_id=-129639785&text=";
      $text = urlencode("No Faktur : ".$nomor_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur' ORDER BY id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
            $pesanan =  $data12['nama_barang']." - ".$data12['jumlah_barang']." - ".$data12['harga']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT kode_barang FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur' ORDER BY id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) 
      {
      $pesanan_jadi = $pesanan_jadi."Subtotal : ".$total;
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      

      
      }


     
     
}


    
            
            $perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$nomor_faktur'");



    // cek query
if (!$stmt2) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}




    echo "Success";

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>