<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';
     include 'cache.class.php'; 


                   
// cek koneksi
if ($db->connect_errno) {
die('Koneksi gagal: ' .$db->connect_errno.
' - '.$db->connect_error);
}


 
// buat prepared statements
$stmt = $db->prepare("INSERT INTO barang (kode_barcode,kode_barang, nama_barang, harga_beli, harga_jual, harga_jual2, harga_jual3,harga_jual4, harga_jual5,harga_jual6, harga_jual7, satuan, kategori, gudang, status, suplier, limit_stok, over_stok,tipe_barang,berkaitan_dgn_stok)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
  
// hubungkan "data" dengan prepared statements
$stmt->bind_param("sssiiiiiiiisssssiiss", 
$barcode,$kode_barang, $nama_barang, $harga_beli, $harga_jual, $harga_jual_2, $harga_jual_3,$harga_jual_4, $harga_jual_5,$harga_jual_6, $harga_jual_7, $satuan, $kategori, $gudang, $status, $suplier, $limit_stok, $over_stok, $golongan,$golongan);
 
// siapkan "data" query
    $barcode = stringdoang($_POST['barcode']);
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
    $suplier = stringdoang($_POST['suplier']);
    $limit_stok = angkadoang($_POST['limit_stok']);
    $over_stok = angkadoang($_POST['over_stok']);
// jalankan query

$stmt->execute();
 


$query_id_barang = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");  
$data_id_barang = mysqli_fetch_array($query_id_barang);  
  
 // setup 'default' cache  
    $c = new Cache();  
    $c->setCache('produk');  
  
    $c->store($kode_barang, array(  
      'kode_barcode' => $barcode,  
      'kode_barang' => $kode_barang,  
      'nama_barang' => $nama_barang,  
      'harga_beli' => $harga_beli,  
      'harga_jual' => $harga_jual,  
      'harga_jual2' => $harga_jual_2,  
      'harga_jual3' => $harga_jual_3,  
      'harga_jual4' => $harga_jual_4,  
      'harga_jual5' => $harga_jual_5,  
      'harga_jual6' => $harga_jual_6,  
      'harga_jual7' => $harga_jual_7,  
      'kategori' => $kategori,  
      'suplier' => $suplier,  
      'limit_stok' => $limit_stok,  
      'over_stok' => $over_stok,  
      'berkaitan_dgn_stok' => $golongan,  
      'tipe_barang' => $golongan,  
      'status' => $status,  
      'satuan' => $satuan,  
      'id' => $data_id_barang['id'] ,  
  
  
    ));  

// cek query
if (!$stmt) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang_jasa">';
}
 
// tutup statements
$stmt->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        
?>

