<?php session_start();


include 'db.php';

 //$jumlah = $_GET['jumlah'];
 $kode_barang = $_POST['kode_barang'];

 //$queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
 //$data = mysqli_fetch_array($queryy);
//echo json_encode($data);


$query_hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang'");

  $query_hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang'");


 $data_hpp_masuk = mysqli_fetch_array($query_hpp_masuk);

 $data_hpp_keluar = mysqli_fetch_array($query_hpp_keluar);

 echo $stok = $data_hpp_masuk['jumlah'] - $data_hpp_keluar['jumlah'];

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
