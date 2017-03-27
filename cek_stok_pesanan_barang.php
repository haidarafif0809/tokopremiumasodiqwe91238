<?php session_start();


include 'db.php';
include 'persediaan.function.php';


 $jumlah_baru = $_POST['jumlah_baru'];
 $kode_barang = $_POST['kode_barang'];


 $stok = cekStokHpp($kode_barang);

 $query_jumlah_brg_order = $db->query("SELECT jumlah_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang'  AND no_faktur_order IS NOT NULL ");
 $data_jumlah_brg_order = mysqli_fetch_array($query_jumlah_brg_order);

 $jumlah_brg_order = $data_jumlah_brg_order['jumlah_barang'];


 echo $hasil1 = ($stok + $jumlah_brg_order) -  $jumlah_baru;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
