<?php session_start();
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST
   $no_faktur = stringdoang($_POST['no_faktur']);
   $total = angkadoang($_POST['total']);
   $user = $_SESSION['nama'];

    
$sisa = $_POST['sisa'];
$sisa_kredit = $_POST['sisa_kredit'];


              if ($sisa >= 0 ) {

 $stmt = $db->prepare("UPDATE  penjualan SET total = ?, jam = now(), user = ?, status = 'Lunas', potongan = ?, tax = ?, sisa = ?, total_hpp = ?, cara_bayar = ?, tunai = ? WHERE no_faktur = ?") ;
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("isiiiisis",
              $total, $user, $potongan, $tax, $sisa_pembayaran, $total_hpp, $cara_bayar, $pembayaran, $no_faktur);
              
               $no_faktur = stringdoang($_POST['no_faktur']);
               $total = angkadoang($_POST['total']);
               $potongan = angkadoang($_POST['potongan']);
               $tax = angkadoang($_POST['tax']);
               $sisa_pembayaran = intval(angkadoang($_POST['sisa_pembayaran']));
               $total_hpp = angkadoang($_POST['total_hpp']);
               $sisa = angkadoang($_POST['sisa']);
               $cara_bayar = stringdoang($_POST['cara_bayar']);
               $pembayaran = angkadoang($_POST['pembayaran']);
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

              }




              else if ($sisa_kredit != 0){

 $stmt = $db->prepare("UPDATE  penjualan SET total = ?, jam = now(), user = ?, status = 'Piutang', potongan = ?, tax = ?, kredit = ?, total_hpp = ?, cara_bayar = ?, tunai = ? WHERE no_faktur = ?") ;
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("isiiiisis",
              $total, $user, $potongan, $tax, $sisa_kredit, $total_hpp, $cara_bayar, $pembayaran, $no_faktur);
              
               $no_faktur = stringdoang($_POST['no_faktur']);
               $total = angkadoang($_POST['total']);
               $potongan = angkadoang($_POST['potongan']);
               $tax = angkadoang($_POST['tax']);
               $sisa_pembayaran = intval(angkadoang($_POST['sisa_pembayaran']));
               $total_hpp = angkadoang($_POST['total_hpp']);
               $sisa = angkadoang($_POST['sisa']);
               $sisa_kredit = angkadoang($_POST['sisa_kredit']);
               $cara_bayar = stringdoang($_POST['cara_bayar']);
               $pembayaran = angkadoang($_POST['pembayaran']);
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

              }
              
             
    

    
    $perintah0 = $db->query("SELECT * FROM fee_faktur WHERE nama_petugas = '$user'");
    $cek = mysqli_fetch_array($perintah0);
    $nominal = $cek['jumlah_uang'];
    $prosentase = $cek['jumlah_prosentase'];

    if ($nominal != 0) {
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek[nama_petugas]', '$no_faktur', '$nominal', now(), now(), '')");

    }

    elseif ($prosentase != 0) {


     
      $fee_prosentase = $prosentase * $total / 100;
      
      $perintah01 = $db->query("INSERT INTO laporan_fee_faktur (nama_petugas, no_faktur, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek[nama_petugas]', '$no_faktur', '$fee_prosentase', now(), now(), '')");
      
    }



              
    $query0 = $db->query("SELECT * FROM tbs_fee_produk WHERE nama_petugas = '$user'");
   while  ($cek0 = mysqli_fetch_array($query0)){



          $query10 = $db->query("INSERT INTO laporan_fee_produk (nama_petugas, no_faktur, kode_produk, nama_produk, jumlah_fee, tanggal, jam, status_bayar) VALUES ('$cek0[nama_petugas]', '$no_faktur', '$cek0[kode_produk]', '$cek0[nama_produk]', '$cek0[jumlah_fee]', now(), now(), '$status_bayar')");


    }
              


    
    $session_id = $_POST['session_id'];
    $kode_meja = $_POST['kode_meja'];

    $query0 = $db->query("UPDATE meja SET status_pakai = 'Belum Terpakai' WHERE kode_meja = '$kode_meja'");


    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE session_id = '$session_id'");
    
 //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);    
    ?>