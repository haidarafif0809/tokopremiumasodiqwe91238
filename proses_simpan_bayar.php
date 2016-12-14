<?php session_start();

    include 'sanitasi.php';
    include 'db.php';


$no_faktur = $_POST['no_faktur'];


$query = $db->query("UPDATE penjualan SET no_pesanan = no_pesanan + 1 WHERE no_faktur = '$no_faktur'");


$select_no_urut = $db->query("SELECT no_pesanan FROM penjualan WHERE no_faktur = '$no_faktur'");

$ambil_select = mysqli_fetch_array($select_no_urut);
$no_pesanan = $ambil_select['no_pesanan']; 
  // bot makanan
      
      $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-134496145&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM detail_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.no_faktur = '$no_faktur' AND b.kategori = 'Minuman' AND tp.no_pesanan = '$no_pesanan'  ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM detail_penjualan tp INNER JOIN barang b ON tp.kode_barang = b.kode_barang  WHERE tp.no_faktur = '$no_faktur' AND b.kategori = 'Minuman' AND tp.no_pesanan = '$no_pesanan' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = url_get_contents($url);
      
      }


     
     
}
        

// bot minuman
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-147051127&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM detail_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.no_faktur = '$no_faktur' AND b.kategori = 'Makanan' AND tp.no_pesanan = '$no_pesanan' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM detail_penjualan tp INNER JOIN barang b ON tp.kode_barang = b.kode_barang  WHERE tp.no_faktur = '$no_faktur' AND b.kategori = 'Makanan' AND tp.no_pesanan = '$no_pesanan' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = url_get_contents($url);
      
      }


     
     
}


// bot beef
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-127377681&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM detail_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.no_faktur = '$no_faktur' AND b.kategori = 'Beef' AND tp.no_pesanan = '$no_pesanan' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM detail_penjualan tp INNER JOIN barang b ON tp.kode_barang = b.kode_barang  WHERE tp.no_faktur = '$no_faktur' AND b.kategori = 'Beef' AND tp.no_pesanan = '$no_pesanan' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = url_get_contents($url);
      
      }


     
     
}


// PRINT OTOMATIS (DARI SINI)
    
$pilih_makanan = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Makanan'");
$ambil_makanan = mysqli_num_rows($pilih_makanan);

if ($ambil_makanan > 0) {
  $insert_status_print_makanan = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Makanan', '$no_pesanan') ");


}


    
$pilih_minuman = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Minuman'");
$ambil_minuman = mysqli_num_rows($pilih_minuman);



if ($ambil_minuman > 0 ) {
  $insert_status_print_minuman = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Minuman', '$no_pesanan') ");
}



$pilih_beef = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Beef'");
$ambil_beef = mysqli_num_rows($pilih_beef);

if ($ambil_beef > 0) {
  $insert_status_print_beef = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Beef', '$no_pesanan') ");
}

 $insert_status_print_bill = $db->query("INSERT INTO status_print (no_faktur,tipe_produk,no_pesanan) VALUES ('$no_faktur', 'Semua', '$no_pesanan') ");

 //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>
