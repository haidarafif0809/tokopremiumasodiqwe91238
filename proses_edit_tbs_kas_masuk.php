<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';


    
   
        $perintah = $db->prepare("INSERT INTO tbs_kas_masuk (no_faktur,keterangan,dari_akun,ke_akun, jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,now(),now(),?)");

        $perintah->bind_param("ssssis",
          $no_faktur, $keterangan, $dari_akun, $ke_akun, $jumlah, $user);
        
        $no_faktur = stringdoang($_POST['no_faktur']);
        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['user_name'];

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