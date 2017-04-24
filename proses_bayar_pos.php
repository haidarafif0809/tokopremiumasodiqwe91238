<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST


    $total = angkadoang($_POST['total']);
    $user = $_SESSION['nama'];
    $session_id = session_id();

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);




//mengecek jumlah karakter dari bulan sekarang
$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

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
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_faktur = "1/JL/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur = $nomor."/JL/".$data_bulan_terakhir."/".$tahun_terakhir;


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


    $sisa = angkadoang($_POST['sisa']);
    $sisa_kredit = angkadoang($_POST['kredit']);
              
              if ($sisa_kredit == 0 ) 

            {
              
              $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, kode_gudang, kode_pelanggan, total, tanggal, jam, user, sales, status, potongan, tax, sisa, total_hpp, cara_bayar, tunai, status_jual_awal) VALUES (?,?,?,?,?,?,?,?,'Lunas',?,?,?,?,?,?,'Tunai')");
              
    // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssissssiiiisi",
              $no_faktur, $kode_gudang, $kode_pelanggan, $total, $tanggal_sekarang, $jam_sekarang, $user, $sales, $potongan, $tax, $sisa, $total_hpp, $cara_bayar, $pembayaran);
              
              
              $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
              $sales = stringdoang($_POST['sales']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);
              $total = angkadoang($_POST['total']);
              $potongan = angkadoang($_POST['potongan']);
              $tax = angkadoang($_POST['tax']);
              $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
              $total_hpp = angkadoang($_POST['total_hpp']);
              $sisa = angkadoang($_POST['sisa']);
              $cara_bayar = stringdoang($_POST['cara_bayar']);
              $pembayaran = angkadoang($_POST['pembayaran']);
              $user = $_SESSION['user_name'];
              $pj_total = $total - ($potongan + $tax);
              $_SESSION['no_faktur'] = $no_faktur;

              
    // jalankan query
              $stmt->execute();
              
              

$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);
$persediaan = $ambil_setting['persediaan'];

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


if ($tax == "" || $tax == 0 || $potongan == "" || $potongan == 0 ) {
  //PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$persediaan', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[kas]', '$total', '0', 'Penjualan', '$no_faktur','1', '$user')");


 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[total_penjualan]', '0', '$total', 'Penjualan', '$no_faktur','1', '$user')");



}
else {
//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$persediaan', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[kas]', '$total', '0', 'Penjualan', '$no_faktur','1', '$user')");


 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[total_penjualan]', '0', '$pj_total', 'Penjualan', '$no_faktur','1', '$user')");

 //Potongan Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[potongan_jual]', '0', '$potongan', 'Penjualan', '$no_faktur','1', '$user')");

 //Pajak Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Tunai - $kode_pelanggan', '$ambil_setting[pajak_jual]', '0', '$tax', 'Penjualan', '$no_faktur','1', '$user')");

      }
              // siapkan "data" query
              
              $total = angkadoang($_POST['total']);
              $cara_bayar = stringdoang($_POST['cara_bayar']);
              
              // jalankan query
              
              
              
            }
              

              else if ($sisa_kredit != 0)
              
            {
              
              
              
              
              $stmt = $db->prepare("INSERT INTO penjualan (no_faktur, kode_gudang, kode_pelanggan, total, tanggal, tanggal_jt, jam, user, sales, status, potongan, tax, kredit, total_hpp, cara_bayar, tunai, status_jual_awal) VALUES (?,?,?,?,?,?,?,?,?,'Piutang',?,?,?,?,?,?,'Kredit')");
              
              // hubungkan "data" dengan prepared statements
              $stmt->bind_param("sssisssssiiiisi",
              $no_faktur, $kode_gudang, $kode_pelanggan, $total , $tanggal_sekarang, $tanggal_jt, $jam_sekarang, $user, $sales, $potongan, $tax, $sisa_kredit, $total_hpp, $cara_bayar, $pembayaran);
              
              
              $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
              $sales = stringdoang($_POST['sales']);
              $kode_gudang = stringdoang($_POST['kode_gudang']);
              $total = angkadoang($_POST['total']);
              $potongan = angkadoang($_POST['potongan']);
              $tax = angkadoang($_POST['tax']);
              $tanggal_jt = angkadoang($_POST['tanggal_jt']);
              $sisa_pembayaran = angkadoang($_POST['sisa_pembayaran']);
              $sisa_kredit = angkadoang($_POST['kredit']);
              $total_hpp = angkadoang($_POST['total_hpp']);
              $cara_bayar = stringdoang($_POST['cara_bayar']);
              $pembayaran = angkadoang($_POST['pembayaran']);
              $user = $_SESSION['user_name'];

$pj_total = $total - ($potongan + $tax);

              $_SESSION['no_faktur'] = $no_faktur;
              
              // jalankan query
              $stmt->execute();


$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);
$persediaan = $ambil_setting['persediaan'];

$select = $db->query("SELECT SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE no_faktur = '$no_faktur'");
$ambil = mysqli_fetch_array($select);

$total_hpp = $ambil['total_hpp'];


if ($tax == "" || $tax == 0 || $potongan == "" || $potongan == 0 ) {

 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[kas]', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$user')");


 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[pembayaran_kredit]', '$sisa_kredit', '0', 'Penjualan', '$no_faktur','1', '$user')");


//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");


//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$persediaan', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");


 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[total_penjualan]', '0', '$total', 'Penjualan', '$no_faktur','1', '$user')");



}
else {
 //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[kas]', '$pembayaran', '0', 'Penjualan', '$no_faktur','1', '$user')");

 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[pembayaran_kredit]', '$sisa_kredit', '0', 'Penjualan', '$no_faktur','1', '$user')");

//HPP    
      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[hpp_penjualan]', '$total_hpp', '0', 'Penjualan', '$no_faktur','1', '$user')");


//PERSEDIAAN    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$persediaan', '0', '$total_hpp', 'Penjualan', '$no_faktur','1', '$user')");

 //Total Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[total_penjualan]', '0', '$pj_total', 'Penjualan', '$no_faktur','1', '$user')");

 //Potongan Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[potongan_jual]', '0', '$potongan', 'Penjualan', '$no_faktur','1', '$user')");

 //Pajak Penjualan
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Penjualan Piutang - $kode_pelanggan', '$ambil_setting[pajak_jual]', '0', '$tax', 'Penjualan', '$no_faktur','1', '$user')");

      }
              // siapkan "data" query
              
              $pembayaran = angkadoang($_POST['pembayaran']);
              $cara_bayar = stringdoang($_POST['cara_bayar']);
              
              // jalankan query
              $stmt10->execute();
              
            }

    else 
            {
                 
            }



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
        # code...
        
        $query2 = $db->query("INSERT INTO detail_penjualan (no_faktur, tanggal, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp, sisa) VALUES ('$no_faktur',now(),'$data[kode_barang]','$data[nama_barang]','$data[jumlah_barang]','$data[satuan]','$data[harga]','$data[subtotal]','$data[potongan]','$data[tax]','$data[hpp]','$data[jumlah_barang]')");

        // cek query
        if (!$query2) 
        {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }


    }







    $query3 = $db->query("DELETE  FROM tbs_penjualan WHERE session_id = '$session_id'");

    $query30 = $db->query("DELETE  FROM tbs_fee_produk WHERE session_id = '$session_id'");

echo $no_faktur;


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>