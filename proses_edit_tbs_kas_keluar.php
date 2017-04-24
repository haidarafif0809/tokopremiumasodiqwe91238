<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';


// buat prepared statements
    $stmt = $db->prepare("INSERT INTO tbs_kas_keluar (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,?,?,?)");

// hubungkan "data" dengan prepared statements
    $stmt->bind_param("ssssisss", 
    $no_faktur, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal, $jam_sekarang,$user);

// siapkan "data" query
        $no_faktur = stringdoang($_POST['no_faktur']);
        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $tanggal = angkadoang($_POST['tanggal']);
        $jam_sekarang = date('H:i:s');
        $user = $_SESSION['nama'];

// jalankan query
        $stmt->execute();
        

        
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {

}
    
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>
