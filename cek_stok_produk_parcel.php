<?php session_start();

 include 'db.php';


 $jumlah_lama = $_GET['jumlah_lama'];
 $jumlah_baru = $_GET['jumlah_baru'];
 $kode_barang = $_GET['kode_barang'];
 $id_produk = $_GET['id_produk'];

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
 $dataaa = mysqli_fetch_array($queryy);
 $stok = $dataaa['total_sisa'];

 $da_produk = $db->query("SELECT nama_barang FROM barang WHERE kode_barang = '$kode_barang' ");
 $am_produk = mysqli_fetch_array($da_produk);
 $nama_produk = $am_produk['nama_barang'];

 $sum_detail_parcel = $db->query("SELECT SUM(jumlah_produk) AS jumlah_produk, id_produk, id_parcel, id FROM detail_perakitan_parcel WHERE id_produk = '$id_produk'");
 $data = mysqli_fetch_array($sum_detail_parcel);
 $jumlah_produk_detail = $data['jumlah_produk'];	

 $total_produk = ($jumlah_produk_detail - $jumlah_lama) + $jumlah_baru;

 $hasil = $stok - $total_produk;
 $sisa_produkk = $jumlah_produk_detail - $jumlah_lama;
 $sisa_produk = $stok - $sisa_produkk;

$data['id_parcel'] = $hasil;
$data['id_produk'] = $nama_produk;
$data['id'] = $sisa_produk;


echo json_encode($data);
exit;

//Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db);
        
?>