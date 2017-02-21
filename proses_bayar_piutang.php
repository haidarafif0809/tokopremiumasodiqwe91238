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
    //ambil bulan dari tanggal penjualan terakhir
    
    $bulan_terakhir = $db->query("SELECT MONTH(tanggal) as bulan FROM pembayaran_piutang ORDER BY id DESC LIMIT 1");
    $v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);
    
    //ambil nomor  dari penjualan terakhir
    $no_terakhir = $db->query("SELECT no_faktur_pembayaran FROM pembayaran_piutang ORDER BY id DESC LIMIT 1");
    $v_no_terakhir = mysqli_fetch_array($no_terakhir);
    $ambil_nomor = substr($v_no_terakhir['no_faktur_pembayaran'],0,-8);
    
    /*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
    maka nomor nya kembali mulai dari 1 ,
    jika tidak maka nomor terakhir ditambah dengan 1
    
    */
    if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
    # code...
    $no_faktur_pembayaran = "1/PP/".$data_bulan_terakhir."/".$tahun_terakhir;
    
    }
    
    else
    {
    
    $nomor = 1 + $ambil_nomor ;
    
    $no_faktur_pembayaran = $nomor."/PP/".$data_bulan_terakhir."/".$tahun_terakhir;
    
    
    }


        // buat prepared statements
        $stmt = $db->prepare("INSERT INTO pembayaran_piutang (no_faktur_pembayaran, tanggal, jam, nama_suplier,keterangan, total, user_buat, dari_kas) VALUES (?,?,?,?,?,?,?,?)");
        
        // hubungkan "data" dengan prepared statements
        $stmt->bind_param("sssssiss", 
        $no_faktur_pembayaran, $tanggal_sekarang, $jam_sekarang, $kode_pelanggan , $keterangan, $total_bayar, $user_buat, $cara_bayar);        
        
        // siapkan "data" query
        $kode_pelanggan = stringdoang($_POST['kode_pelanggan']);
        $keterangan = stringdoang($_POST['keterangan']);
        $total_bayar = angkadoang($_POST['total_bayar']);
        $user_buat = $_SESSION['user_name'];
        $cara_bayar = stringdoang($_POST['cara_bayar']);
        
        $_SESSION['no_faktur_pembayaran'] = $no_faktur_pembayaran;
        
        // jalankan query
        $stmt->execute();

  


    $query = $db->query("SELECT * FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'");
    while ($data = mysqli_fetch_array($query))
    {

       $query2 ="INSERT INTO detail_pembayaran_piutang (no_faktur_pembayaran, no_faktur_penjualan,tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar) VALUES ('$no_faktur_pembayaran','$data[no_faktur_penjualan]', '$tanggal_sekarang','$data[tanggal_jt]','$data[kredit]','$data[potongan]','$data[total]','$data[jumlah_bayar]')";

       if ($db->query($query2) === TRUE) {
       } else {
       echo "Error: " . $query2 . "<br>" . $db->error;
       }


    }



        $total_bayar = angkadoang($_POST['total_bayar']);
        $user_buat = $_SESSION['user_name'];
        $cara_bayar = stringdoang($_POST['cara_bayar']);

    $select_kode_pelanggan = $db->query("SELECT nama_pelanggan FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
    $ambil_kode_pelanggan = mysqli_fetch_array($select_kode_pelanggan);

    $select_setting_akun = $db->query("SELECT * FROM setting_akun");
    $ambil_setting = mysqli_fetch_array($select_setting_akun);

$tbs_piutang = $db->query("SELECT potongan FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'");
$data_tbs_pot = mysqli_fetch_array($tbs_piutang);

$potongan = $data_tbs_pot['potongan'];
$piutang = $total_bayar + $potongan;


 //KAS
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$cara_bayar', '$total_bayar', '0', 'Pembayaran Piutang', '$no_faktur_pembayaran','1', '$user_buat')");


 //PIUTANG
        $insert_juranl = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[pembayaran_kredit]', '0', '$piutang', 'Pembayaran Piutang', '$no_faktur_pembayaran','1', '$user_buat')");


if ($potongan != "" || $potongan != '0') {
     //POTONGAN PIUTANG    
        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$tanggal_sekarang $jam_sekarang', 'Pembayaran Piutang - $ambil_kode_pelanggan[nama_pelanggan]', '$ambil_setting[potongan_piutang]', '$potongan', '0', 'Pembayaran Piutang', '$no_faktur_pembayaran','1', '$user_buat')");
}

    $query3 = $db->query("DELETE FROM tbs_pembayaran_piutang WHERE session_id = '$session_id'");
    echo "Berhasil";


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);       

    ?>