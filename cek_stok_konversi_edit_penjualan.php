<?php session_start();


include 'db.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_barang = $_POST['jumlah_barang'];
 $kode_barang = $_POST['kode_barang'];
 $id_produk = $_POST['id_produk'];
 $no_faktur = $_POST['no_faktur'];


$queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
$dataaa = mysqli_fetch_array($queryy);


$queryyy = $db->query("SELECT IFNULL(dp.jumlah_barang,0) AS jumlah_detail ,IFNULL(tp.jumlah_barang,0) AS jumlah_tbs FROM detail_penjualan dp LEFT JOIN tbs_penjualan tp ON dp.no_faktur = tp.no_faktur WHERE dp.kode_barang = '$kode_barang' AND dp.no_faktur = '$no_faktur'");
$data000 = mysqli_fetch_array($queryyy);

$stok_barang = $dataaa['total_sisa'];

$sisa_barang = ($stok_barang + $data000['jumlah_detail']) - $data000['jumlah_tbs'];


 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND id_produk = '$id_produk'");
 $data = mysqli_fetch_array($query);

 $hasil = $jumlah_barang * $data['konversi'];
 
 echo $hasil1 = $sisa_barang - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
