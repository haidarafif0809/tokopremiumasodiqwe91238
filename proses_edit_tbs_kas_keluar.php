<?php session_start();

    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';


    //mengirim data sesuai dengan variabel denagn metode POST 



// buat prepared statements
    $stmt = $db->prepare("INSERT INTO tbs_kas_keluar (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,now(),now(),?)");

// hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssis", 
        $no_faktur, $keterangan, $dari_akun, $ke_akun, $jumlah, $user);        
        
// siapkan "data" query
        $no_faktur = stringdoang($_POST['no_faktur']);
        $keterangan = stringdoang($_POST['keterangan']);
        $dari_akun = stringdoang($_POST['dari_akun']);
        $ke_akun = stringdoang($_POST['ke_akun']);
        $jumlah = angkadoang($_POST['jumlah']);
        $user = $_SESSION['user_name'];

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
