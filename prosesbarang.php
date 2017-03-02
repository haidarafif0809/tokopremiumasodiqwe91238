<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';


                   
// cek koneksi
if ($db->connect_errno) {
die('Koneksi gagal: ' .$db->connect_errno.
' - '.$db->connect_error);
}


 
// buat prepared statements
$stmt = $db->prepare("INSERT INTO barang (kode_barang, nama_barang, harga_beli, harga_jual, harga_jual2, harga_jual3,harga_jual4, harga_jual5,harga_jual6, harga_jual7, satuan, kategori, gudang, status, suplier, limit_stok, over_stok,tipe_barang,berkaitan_dgn_stok)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  
// hubungkan "data" dengan prepared statements
$stmt->bind_param("ssiiiiiiiisssssiiss", 
$kode_barang, $nama_barang, $harga_beli, $harga_jual, $harga_jual_2, $harga_jual_3,$harga_jual_4, $harga_jual_5,$harga_jual_6, $harga_jual_7, $satuan, $kategori, $gudang, $status, $suplier, $limit_stok, $over_stok, $tipe,$golongan);
 
// siapkan "data" query
    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $harga_beli = angkadoang($_POST['harga_beli']);
    $harga_jual = angkadoang($_POST['harga_jual']);
    $harga_jual_2 = angkadoang($_POST['harga_jual_2']);
    $harga_jual_3 = angkadoang($_POST['harga_jual_3']);
    $harga_jual_4 = angkadoang($_POST['harga_jual_4']);
    $harga_jual_5 = angkadoang($_POST['harga_jual_5']);
    $harga_jual_6 = angkadoang($_POST['harga_jual_6']);
    $harga_jual_7 = angkadoang($_POST['harga_jual_7']);
   
    $golongan = stringdoang($_POST['golongan_produk']);
    $satuan = stringdoang($_POST['satuan']);
    $kategori = stringdoang($_POST['kategori_obat']);
    $gudang = stringdoang($_POST['gudang']);
    $status = stringdoang($_POST['status']);
    $tipe = stringdoang($_POST['tipe']);
    $suplier = stringdoang($_POST['suplier']);
    $limit_stok = angkadoang($_POST['limit_stok']);
    $over_stok = angkadoang($_POST['over_stok']);
// jalankan query

$stmt->execute();
 
// cek query
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang">';
}
 
// tutup statements
$stmt->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        
?>

