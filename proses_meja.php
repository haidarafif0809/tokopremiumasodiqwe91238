<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';

       
// buat prepared statements
$stmt = $db->prepare("INSERT INTO meja (kode_meja, nama_meja, status_pakai)
            VALUES (?,?,'Belum Terpakai')");
  
// hubungkan "data" dengan prepared statements
$stmt->bind_param("ss", 
$kode_meja, $nama_meja);
 
// siapkan "data" query
    $kode_meja = stringdoang($_POST['kode_meja']);
    $nama_meja = stringdoang($_POST['nama_meja']);
// jalankan query
$stmt->execute();
 
// cek query
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
   echo "sukses";
}
 
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>

