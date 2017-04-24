<?php session_start();


    include 'sanitasi.php';
    include 'db.php';
    //mengirim data disetiap masing-masing variabel menggunakan metode POST

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
//ambil bulan dari tanggal pembayaran_hutang terakhir

 $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM pembayaran_hutang ORDER BY id DESC LIMIT 1");
 $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari pembayaran_hutang terakhir
$no_terakhir = $db->query("SELECT no_faktur_pembayaran FROM pembayaran_hutang ORDER BY id DESC LIMIT 1");
 $v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur_pembayaran'],0,-8);

/*jika bulan terakhir dari pembayaran_hutang tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1
 
 */
 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
  # code...
$no_faktur_pembayaran = "1/PH/".$data_bulan_terakhir."/".$tahun_terakhir;

 }

 else
 {

$nomor = 1 + $ambil_nomor ;

$no_faktur_pembayaran = $nomor."/PH/".$data_bulan_terakhir."/".$tahun_terakhir;


 }





        // buat prepared statements
        $stmt = $db->prepare("INSERT INTO pembayaran_hutang (no_faktur_pembayaran,tanggal,jam,nama_suplier,keterangan, total, user_buat,dari_kas) VALUES (?,?,?,?,?,?,?,?)");
        
        // hubungkan "data" dengan prepared statements
        $stmt->bind_param("sssssiss", 
        $no_faktur_pembayaran, $tanggal_sekarang, $jam_sekarang, $suplier,$keterangan,$total_bayar,$user_buat,$cara_bayar);        
        
        // siapkan "data" query
        $suplier = stringdoang($_POST['suplier']);
        $keterangan = stringdoang($_POST['keterangan']);
        $total_bayar = angkadoang($_POST['total_bayar']);
        $user_buat = $_SESSION['user_name'];
        $cara_bayar = stringdoang($_POST['cara_bayar']);
        
        $_SESSION['no_faktur_pembayaran'] = $no_faktur_pembayaran;
        
        // jalankan query
        $stmt->execute();
        
        if (!$stmt) {
        die('Query Error : '.$db->errno.
        ' - '.$db->error);
        }
        else {
        
        }

        
        $query = $db->query("SELECT * FROM tbs_pembayaran_hutang WHERE session_id = '$session_id'");
        while ($data = mysqli_fetch_array($query))
        {

        
        $query2 = $db->query("INSERT INTO detail_pembayaran_hutang (no_faktur_pembayaran, no_faktur_pembelian, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar) 
        VALUES ('$no_faktur_pembayaran','$data[no_faktur_pembelian]', '$tanggal_sekarang','$data[tanggal_jt]','$data[kredit]','$data[potongan]','$data[total]','$data[jumlah_bayar]')");
        }

   



        $suplier = stringdoang($_POST['suplier']);
        $total_bayar = angkadoang($_POST['total_bayar']);
        $user_buat = $_SESSION['user_name'];


$select_setting_akun = $db->query("SELECT * FROM setting_akun");
$ambil_setting = mysqli_fetch_array($select_setting_akun);

$select_suplier = $db->query("SELECT id,nama FROM suplier WHERE id = '$suplier'");
$ambil_suplier = mysqli_fetch_array($select_suplier);

$tbs_hutang = $db->query("SELECT potongan FROM tbs_pembayaran_hutang WHERE session_id = '$session_id'");
$data_tbs_pot = mysqli_fetch_array($tbs_hutang);

$potongan = $data_tbs_pot['potongan'];
$hutang = $total_bayar + $potongan;

        //HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Hutang - $ambil_suplier[nama]', '$ambil_setting[hutang]', '$hutang', '0', 'Pembayaran Hutang', '$no_faktur_pembayaran','1', '$user_buat')");

        //KAS
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Hutang - $ambil_suplier[nama]', '$cara_bayar', '0', '$total_bayar', 'Pembayaran Hutang', '$no_faktur_pembayaran','1', '$user_buat')");

if ($potongan != "" || $potongan != '0') {
     //POTONGAN HUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Hutang - $ambil_suplier[nama]', '$ambil_setting[potongan_hutang]', '0', '$potongan', 'Pembayaran Hutang', '$no_faktur_pembayaran','1', '$user_buat')");
}
       


        $query3 = $db->query("DELETE FROM tbs_pembayaran_hutang WHERE session_id = '$session_id'");
        echo "Success";


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);       

    ?>