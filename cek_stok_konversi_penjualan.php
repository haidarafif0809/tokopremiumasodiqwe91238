<?php session_start();


include 'db.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_barang = $_POST['jumlah_barang'];
 $kode_barang = $_POST['kode_barang'];
  $id_produk = $_POST['id_produk'];

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
 $dataaa = mysqli_fetch_array($queryy);

 $stok = $dataaa['total_sisa'];

 

 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND id_produk = '$id_produk'");
 $data = mysqli_fetch_array($query);

 $hasil = $jumlah_barang * $data['konversi'];
 echo $hasil1 = $stok - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
