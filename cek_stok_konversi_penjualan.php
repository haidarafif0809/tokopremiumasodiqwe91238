<?php session_start();


include 'db.php';
include 'persediaan.function.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_barang = $_POST['jumlah_barang'];
 $kode_barang = $_POST['kode_barang'];
  $id_produk = $_POST['id_produk'];

 $stok = cekStokHpp($kode_barang);

 

 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND id_produk = '$id_produk'");
 $data = mysqli_fetch_array($query);

 $hasil = $jumlah_barang * $data['konversi'];
 echo $hasil1 = $stok - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
