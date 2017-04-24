<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';


        $perintah = $db->prepare("INSERT INTO tbs_kas_masuk (no_faktur,keterangan,dari_akun,ke_akun, jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,?,?,?)");

        $perintah->bind_param("ssssisss",
          $no_faktur, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal,
          $jam_sekarang, $user);
        
        $no_faktur = stringdoang($_POST['no_faktur']);
        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $tanggal = stringdoang($_POST['tanggal']);
        $jam_sekarang = date('H:i:s');
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