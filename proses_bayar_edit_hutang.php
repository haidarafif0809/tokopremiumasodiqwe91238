<?php session_start();


    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST



    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);

$perintah10 = $db->query("DELETE FROM detail_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");




  // buat prepared statements
        $stmt = $db->prepare("UPDATE pembayaran_hutang SET no_faktur_pembayaran = ?, tanggal = ?, tanggal_edit = ?, jam = ?, nama_suplier = ?, keterangan = ?, total = ?, user_edit = ?, dari_kas = ? WHERE no_faktur_pembayaran = ?");

  // hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssssisss", 
        $no_faktur_pembayaran, $tanggal, $tanggal_sekarang, $jam_sekarang, $suplier , $keterangan, $total_bayar, $user_edit, $cara_bayar, $no_faktur_pembayaran);        

  // siapkan "data" query
    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);
    $suplier = stringdoang($_POST['suplier']);
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
        
    

 $perintah2 = $db->query("UPDATE pembelian SET status = 'Lunas' WHERE kredit = 0");



    $query = $db->query("SELECT * FROM tbs_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
    while ($data = mysqli_fetch_array($query))
    {


        $query2 = $db->query("INSERT INTO detail_pembayaran_hutang (no_faktur_pembayaran, no_faktur_pembelian, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar) VALUES ('$data[no_faktur_pembayaran]', '$data[no_faktur_pembelian]', now(), '$data[tanggal_jt]', '$data[kredit]', '$data[potongan]', '$data[total]', '$data[jumlah_bayar]')");
    }


    $no_faktur_pembayaran = stringdoang($_POST['no_faktur_pembayaran']);

    $query50 = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur_pembayaran'");



$tanggal = stringdoang($_POST['tanggal']);
$jam_sekarang = date('H:i:sa');


$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);

$tbs_hutang = $db->query("SELECT potongan FROM tbs_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
$data_tbs_pot = mysqli_fetch_array($tbs_hutang);

$potongan = $data_tbs_pot['potongan'];
$hutang = $total_bayar + $potongan;

        //HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembayaran Hutang - $ambil_suplier[nama]', '$ambil_setting[hutang]', '$hutang', '0', 'Pembayaran Hutang', '$no_faktur_pembayaran','1', '$user_edit','$user_edit')");

        //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$tanggal $jam_sekarang', 'Pembayaran Hutang - $ambil_suplier[nama]', '$cara_bayar', '0', '$total_bayar', 'Pembayaran Hutang', '$no_faktur_pembayaran','1', '$user_edit','$user_edit')");

if ($potongan != "" || $potongan != '0') {
     //POTONGAN HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Hutang - $ambil_suplier[nama]', '$ambil_setting[potongan_hutang]', '0', '$potongan', 'Pembayaran Hutang', '$no_faktur_pembayaran','1', '$user_edit')");
}


    $query3 = $db->query("DELETE FROM tbs_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
    echo "Success";


    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>