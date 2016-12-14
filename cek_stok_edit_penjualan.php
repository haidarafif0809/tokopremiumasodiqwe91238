<?php session_start();


include 'db.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_baru = $_POST['jumlah_baru'];
 $kode_barang = $_POST['kode_barang'];
 $no_faktur = $_POST['no_faktur'];

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
 $dataaa = mysqli_fetch_array($queryy);
 $stok_barang = $dataaa['total_sisa'];


	$queryyy = $db->query("SELECT dp.jumlah_barang AS jumlah_detail ,tp.jumlah_barang AS jumlah_tbs  FROM detail_penjualan dp LEFT JOIN tbs_penjualan tp ON dp.no_faktur = tp.no_faktur WHERE dp.kode_barang = '$kode_barang' AND dp.no_faktur = '$no_faktur' ");
     
     $data000 = mysqli_fetch_array($queryyy);

     
     $sisa_barang = ($stok_barang + $data000['jumlah_detail']);


 
 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND kode_produk = '$kode_barang'");
 $data = mysqli_fetch_array($query);

 if ($data['konversi'] == "") {

 $hasil = $jumlah_baru;
 	
 }

 else{

 $hasil = $jumlah_baru * $data['konversi'];

 }

 echo $hasil1 = $sisa_barang - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
