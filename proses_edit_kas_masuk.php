<?php session_start();

    include 'sanitasi.php';
    include 'db.php';
    
$no_faktur = stringdoang($_POST['no_faktur']);


$jam_sekarang = date('H:i:sa');
$waktu = date('Y-m-d H:i:s');

$query5 = $db->query("DELETE FROM detail_kas_masuk WHERE no_faktur = '$no_faktur'");  
$hapus_jurnal = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur'");

    $perintah = $db->prepare("UPDATE kas_masuk SET no_faktur = ?, keterangan = ?, ke_akun = ?, jumlah = ?, tanggal = ?, jam = ?, user_edit = ?, waktu_edit = ? WHERE no_faktur = ?");

    $perintah->bind_param("sssisssss",
        $no_faktur, $keterangan, $ke_akun , $jumlah, $tanggal, $jam_sekarang, $user, $waktu, $no_faktur);

    $no_faktur = stringdoang($_POST['no_faktur']);
    $keterangan = stringdoang($_POST['keterangan']);
    $ke_akun = stringdoang($_POST['ke_akun']);
    $tanggal = stringdoang($_POST['tanggal']);
    $jumlah = angkadoang($_POST['jumlah']);
    $user = $_SESSION['nama'];
    $no_faktur = stringdoang($_POST['no_faktur']);

    $perintah->execute();




if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
    echo "sukses";

}

    $query1 = $db->query("SELECT * FROM tbs_kas_masuk WHERE no_faktur = '$no_faktur'");

    while ($data=mysqli_fetch_array($query1)) {

    $query2 = $db->query("INSERT INTO detail_kas_masuk (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user) VALUES ('$no_faktur','$data[keterangan]','$data[dari_akun]','$data[ke_akun]','$data[jumlah]','$data[tanggal]','$data[jam]','$data[user]')");
    
    }
    

//jurnal


    $ke_akun = stringdoang($_POST['ke_akun']);

    $ambil_tbs = $db->query("SELECT * FROM tbs_kas_masuk WHERE no_faktur = '$no_faktur'");
    while ($ambil = mysqli_fetch_array($ambil_tbs))
    {

            $pilih = $db->query("SELECT dk.ke_akun, da.nama_daftar_akun, jt.kode_akun_jurnal FROM detail_kas_masuk dk INNER JOIN daftar_akun da ON dk.ke_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON dk.ke_akun = jt.kode_akun_jurnal");
            $ke_akun_select = mysqli_fetch_array($pilih);

            $pilih = $db->query("SELECT dk.dari_akun, da.nama_daftar_akun, jt.kode_akun_jurnal FROM detail_kas_masuk dk INNER JOIN daftar_akun da ON dk.dari_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON dk.dari_akun = jt.kode_akun_jurnal WHERE jt.kode_akun_jurnal = '$ambil[dari_akun]'");
            $dari_akun_select = mysqli_fetch_array($pilih);


        $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Masuk ke $ke_akun_select[nama_daftar_akun]','$ambil[ke_akun]', '$ambil[jumlah]', '0', 'Kas Masuk', '$no_faktur','1', '$user', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Masuk dari $dari_akun_select[nama_daftar_akun]','$ambil[dari_akun]', '0', '$ambil[jumlah]', 'Kas Masuk', '$no_faktur','1', '$user', '$user')");
       
    }


    $query3 = $db->query("DELETE FROM tbs_kas_masuk WHERE no_faktur = '$no_faktur'");                      
  
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>