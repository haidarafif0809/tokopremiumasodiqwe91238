<?php session_start();


    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);


    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);

$perintah10 = $db->query("DELETE FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");


  // buat prepared statements
        $stmt = $db->prepare("UPDATE pembayaran_piutang SET no_faktur_pembayaran = ?, tanggal = ?, jam = ?, tanggal_edit = ?, nama_suplier = ?, keterangan = ?, total = ?, user_edit = ?, dari_kas = ? WHERE no_faktur_pembayaran = ?");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssssisss", 
        $no_faktur_pembayaran, $tanggal, $jam_sekarang, $tanggal_sekarang, $kode_pelanggan , $keterangan, $total_bayar, $user_edit, $cara_bayar, $no_faktur_pembayaran);        

  // siapkan "data" query
    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);
    $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
    $keterangan = stringdoang($_POST['keterangan']);
    $total_bayar = angkadoang($_POST['total_bayar']);
    $user_edit = $_SESSION['user_name'];
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $tanggal = stringdoang($_POST['tanggal']);

    $_SESSION['no_faktur_pembayaran'] = $no_faktur_pembayaran;

  // jalankan query
        $stmt->execute();

        if (!$stmt) {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }
        else {
        
        }
        

 $perintah2 = $db->query("UPDATE penjualan SET status = 'Lunas' WHERE kredit = 0");

    $query = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
    while ($data = mysqli_fetch_array($query))
    {
        # code...
     

        $query2 = $db->query("INSERT INTO detail_pembayaran_piutang (no_faktur_pembayaran, no_faktur_penjualan, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar) VALUES ('$data[no_faktur_pembayaran]', '$data[no_faktur_penjualan]', now(), '$data[tanggal_jt]', '$data[kredit]', '$data[potongan]', '$total_bayar', '$data[jumlah_bayar]')");
    }



    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);

    $total_bayar = angkadoang($_POST['total_bayar']);
    $user_edit = $_SESSION['user_name'];
    $cara_bayar = stringdoang($_POST['cara_bayar']);
    $tanggal = stringdoang($_POST['tanggal']);


$query50 = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur_pembayaran'");

    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    $select_setting_akun = $db->query("SELECT * FROM setting_akun");
    $ambil_setting = mysqli_fetch_array($select_setting_akun);

$tbs_piutang = $db->query("SELECT potongan FROM tbs_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
$data_tbs_pot = mysqli_fetch_array($tbs_piutang);

$potongan = $data_tbs_pot['potongan'];
$piutang = $total_bayar + $potongan;

 //KAS
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total_bayar', '0', 'Pembayaran Piutang', '$no_faktur_pembayaran','1', '$user_edit','$user_edit')");


 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '0', '$piutang', 'Pembayaran Piutang', '$no_faktur_pembayaran','1', '$user_edit','$user_edit')");

if ($potongan != "" || $potongan != '0') {
     //POTONGAN PIUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_piutang]', '$potongan', '0', 'Pembayaran Piutang', '$no_faktur_pembayaran','1', '$user_buat')");
}

    $query3 = $db->query("DELETE FROM tbs_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
    echo "Success";


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);       

    ?>