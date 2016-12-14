<?php session_start();
    
    include 'sanitasi.php';
    include 'db.php';


    $no_faktur = stringdoang($_POST['no_faktur']);

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$waktu = date('Y-m-d H:i:sa');

$query5 = $db->query("DELETE FROM detail_kas_keluar WHERE no_faktur = '$no_faktur'");  

// buat prepared statements
    $stmt = $db->prepare("UPDATE kas_keluar SET no_faktur = ?, dari_akun = ?, jumlah = ?, tanggal = ?, jam = ?, user = ? WHERE no_faktur = ?");

// hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssissss", 
        $no_faktur, $dari_akun, $jumlah, $tanggal,  $jam_sekarang, $user, $no_faktur);

// siapkan "data" query
        $no_faktur = stringdoang($_POST['no_faktur']);
        $tanggal = stringdoang($_POST['tanggal']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['user_name'];

        $no_faktur = stringdoang($_POST['no_faktur']);

// jalankan query
        $stmt->execute();


// buat prepared statements    
    $stmt1 = $db->prepare("UPDATE kas SET jumlah = jumlah - ? WHERE nama = ? ");

// hubungkan "data" dengan prepared statements
        $stmt1->bind_param("is", 
        $jumlah , $dari_akun);        

  // siapkan "data" query
        $dari_akun = stringdoang($_POST['dari_akun']);
        $jumlah = angkadoang($_POST['jumlah']);

 // jalankan query
        $stmt1->execute();


if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}
    

   $query1 = $db->query("SELECT * FROM tbs_kas_keluar WHERE no_faktur = '$no_faktur'");

    while ($data=mysqli_fetch_array($query1)) {

    $query2 = $db->query("INSERT INTO detail_kas_keluar (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user) VALUES ('$no_faktur','$data[keterangan]','$data[dari_akun]','$data[ke_akun]','$data[jumlah]','$data[tanggal]','$data[jam]','$data[user]')");
    
    }


//jurnal



   $ambil_tbs = $db->query("SELECT * FROM tbs_kas_keluar WHERE no_faktur = '$no_faktur'");
    while ($ambil = mysqli_fetch_array($ambil_tbs))

{

            $pilih = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.dari_akun FROM daftar_akun da INNER JOIN detail_kas_keluar dk ON dk.dari_akun = da.kode_daftar_akun");
            $dari_akun_select = mysqli_fetch_array($pilih);

            $select = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.ke_akun FROM daftar_akun da INNER JOIN detail_kas_keluar dk ON dk.ke_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON jt.kode_akun_jurnal = da.kode_daftar_akun WHERE jt.kode_akun_jurnal = '$ambil[ke_akun]'");
            $ke_akun_select = mysqli_fetch_array($select);

      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Keluar dari $dari_akun_select[nama_daftar_akun]','$ambil[dari_akun]', '0', '$ambil[jumlah]', 'Kas Keluar', '$no_faktur','1', '$user', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat, user_edit) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Keluar ke $ke_akun_select[nama_daftar_akun]','$ambil[ke_akun]', '$ambil[jumlah]', '0', 'Kas Keluar', '$no_faktur','1', '$user', '$user')");

}
    $query3 = $db->query("DELETE FROM tbs_kas_keluar WHERE no_faktur = '$no_faktur'");                      
  
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>