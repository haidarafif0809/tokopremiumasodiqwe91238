<?php session_start();
 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST

    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $total = angkadoang($_POST['total']);
    $kode_meja = stringdoang($_POST['kode_meja']);
    $user = $_SESSION['nama'];

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
//ambil bulan dari tanggal penjualan terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM penjualan ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $v_bulan['bulan']) {
  # code...
$no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


 }


$query = $db->query("UPDATE meja SET status_pakai = 'Sudah Terpakai' WHERE kode_meja = '$kode_meja'");



              
$stmt = $db->prepare("INSERT INTO penjualan (no_faktur, kode_pelanggan, kode_meja, tanggal, jam, user, status, potongan, tax, no_pesanan) VALUES (?,?,?,now(),now(),?,'Sudah Terpakai',?,?,'1')");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("ssssii",
              $no_faktur, $kode_pelanggan, $kode_meja, $user, $potongan, $tax);
              
              $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
              $potongan = angkadoang($_POST['potongan']);
              $tax = angkadoang($_POST['tax']);
              $kode_meja = stringdoang($_POST['kode_meja']);
              $user = $_SESSION['user_name'];

              $_SESSION['no_faktur'] = $no_faktur;

              
    // jalankan query
              $stmt->execute();
              
              


    // cek query
if (!$stmt) 
   {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
   }

else 
    {
    
    }



    $query = $db->query("SELECT * FROM tbs_penjualan WHERE session_id = '$session_id'");
    while ($data = mysqli_fetch_array($query))
    {
        
        
        $query2 = $db->query("INSERT INTO detail_penjualan (no_faktur, kode_meja, tanggal, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp, sisa, no_pesanan, komentar) VALUES ('$no_faktur','$kode_meja',now(),'$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[satuan]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]','$data[hpp]','$data[jumlah_barang]', '1', '$data[komentar]')");




    }



   
    echo "Success";

   
    // bot makanan
      
      $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-134496145&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Minuman' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Minuman' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = file_get_contents($url);
      
      }


     
     
}
        

// bot minuman
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-147051127&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Makanan' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Makanan' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = file_get_contents($url);
      
      }


     
     
}


// bot beef
     $ambil_tbs = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
      $data10 = mysqli_fetch_array($ambil_tbs);
      
      $url = "https://api.telegram.org/bot209101173:AAG1zjYq2rTH2SkspeEgVYS8f6DqOYILVyc/sendMessage?chat_id=-127377681&text=";
      $text = urlencode("Meja : ".$data10['kode_meja']."\n No Faktur : ".$no_faktur."\n");
      $pesanan_jadi = "";
      $ambil_tbs1 = $db->query("SELECT tp.kode_barang, tp.nama_barang, tp.jumlah_barang, tp.komentar  FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Beef' ORDER BY tp.id ASC");
      
 while ($data12 = mysqli_fetch_array($ambil_tbs1))

 {
      
      $pesanan =  $data12['nama_barang']." ".$data12['jumlah_barang']." ".$data12['komentar']."\n";
      $pesanan_jadi = $pesanan_jadi.$pesanan;
      
      $ambil_tbs2 = $db->query("SELECT tp.kode_barang FROM tbs_penjualan tp INNER JOIN barang b ON b.kode_barang = tp.kode_barang  WHERE tp.session_id = '$session_id' AND b.kategori = 'Beef' ORDER BY tp.id DESC Limit 1");
      $ambil_tbs3 = mysqli_fetch_array($ambil_tbs2);
      $data_terakhir = $ambil_tbs3['kode_barang'];
      
      if ($data12['kode_barang'] == $data_terakhir ) {
      
      $pesanan_terakhir =  urlencode($pesanan_jadi);
      $url = $url.$text.$pesanan_terakhir;
      
      $url = str_replace(" ", "%20", $url);
      
      $bot_wiseman = file_get_contents($url);
      
      }


     
     
}
  
// PRINT OTOMATIS (DARI SINI)
    
$pilih_makanan = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Makanan'");
$ambil_makanan = mysqli_num_rows($pilih_makanan);



if ($ambil_makanan > 0) {
  $insert_status_print_makanan = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Makanan', '1') ");


}


    
$pilih_minuman = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Minuman'");
$ambil_minuman = mysqli_num_rows($pilih_minuman);



if ($ambil_minuman > 0 ) {
  $insert_status_print_minuman = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Minuman', '1') ");
}



$pilih_beef = $db->query("SELECT dp.no_faktur, dp.no_pesanan, b.kategori FROM detail_penjualan dp INNER JOIN barang b ON dp.kode_barang = b.kode_barang WHERE dp.no_faktur = '$no_faktur' AND b.kategori = 'Beef'");
$ambil_beef = mysqli_num_rows($pilih_beef);

if ($ambil_beef > 0) {
  $insert_status_print_beef = $db->query("INSERT INTO status_print (no_faktur, tipe_produk, no_pesanan) VALUES ('$no_faktur', 'Beef', '1') ");
}


    

  $insert_status_print_bill = $db->query("INSERT INTO status_print (no_faktur,tipe_produk,no_pesanan) VALUES ('$no_faktur', 'Semua', '1') ");






     $query00 = $db->query("DELETE FROM tbs_penjualan WHERE session_id = '$session_id'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>