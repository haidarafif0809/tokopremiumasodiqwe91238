<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';


    $nama_barang = stringdoang($_POST['nama_barang']);
    $total_belanja = angkadoang($_POST['total_belanja']);
    $free_produk = angkadoang($_POST['free_produk']);
// buat prepared statements
$stmt = $db->prepare("INSERT INTO promo_free_produk (nama_barang, total_belanja, free_produk)
            VALUES (?,?,?)");
  
// hubungkan "data" dengan prepared statements
$stmt->bind_param("sis", 
$nama_barang, $total_belanja, $free_produk);

// jalankan query
$stmt->execute();
 
// cek query
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=promo_free_produk.php">';
}
 
// tutup statements
$stmt->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        
?>
?>