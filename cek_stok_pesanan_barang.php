<?php session_start();


include 'db.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_baru = $_POST['jumlah_baru'];
 $kode_barang = $_POST['kode_barang'];

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
 $dataaa = mysqli_fetch_array($queryy);
 $stok = $dataaa['total_sisa'];

  $queryy22 = $db->query("SELECT jumlah_barang FROM tbs_penjualan WHERE kode_barang = '$kode_barang'  AND no_faktur_order IS NOT NULL ");
 $dataaa22 = mysqli_fetch_array($queryy22);
 $jumlah_brg_order = $dataaa22['jumlah_barang'];

 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND kode_produk = '$kode_barang'");
 $data = mysqli_fetch_array($query);

 if ($data['konversi'] == "") {

 $hasil = $jumlah_baru;
 	
 }

 else{

 $hasil = $jumlah_baru * $data['konversi'];

 }

 echo $hasil1 = ($stok - $jumlah_brg_order) - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
