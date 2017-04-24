<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $session_id = $_POST['session_id'];
$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);
$tanggal = stringdoang($_POST['tanggal']);
$waktu = $tanggal." ".$jam_sekarang;
   
        $perintah = $db->prepare("INSERT INTO tbs_kas_masuk (session_id,keterangan,dari_akun,ke_akun, jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,?,?,?)");

        $perintah->bind_param("ssssisss",
          $session_id, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal_sekarang, $jam_sekarang, $user);
        
        
        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['nama'];

        $perintah->execute();
        

if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>