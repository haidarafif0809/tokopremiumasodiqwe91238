<?php session_start();

 include 'db.php';

 $jumlah_parcel = $_GET['jumlah_parcel'];
 $jumlah_baru = $_GET['jumlah_barang'];
 $kode_barang = $_GET['kode_barang'];
 $id_produk = $_GET['id_produk'];

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa, jenis_hpp, jenis_transaksi FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
 $dataaa = mysqli_fetch_array($queryy);
 $stok = $dataaa['total_sisa'];

 $jumlah_produk_yg_diperlukan = $jumlah_baru * $jumlah_parcel;
 $hasil = $stok - $jumlah_produk_yg_diperlukan;

 $total_parcel = $stok / $jumlah_baru;
 $total_parcel_yg_bisa_dibuat = round($total_parcel) - 1;


$data['jenis_hpp'] = $hasil;
$data['jenis_transaksi'] = $total_parcel_yg_bisa_dibuat;


echo json_encode($data);
exit;

//Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db);
        
?>