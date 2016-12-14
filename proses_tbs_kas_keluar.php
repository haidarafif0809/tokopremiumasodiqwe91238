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
//mengirim data sesuai dengan variabel denagn metode POST 



// buat prepared statements
    $stmt = $db->prepare("INSERT INTO tbs_kas_keluar (session_id,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user) VALUES (?,?,?,?,?,?,?,?)");

// hubungkan "data" dengan prepared statements
        $stmt->bind_param("ssssisss", 
        $session_id, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal, $jam_sekarang, $user);        
        
// siapkan "data" query
        
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
