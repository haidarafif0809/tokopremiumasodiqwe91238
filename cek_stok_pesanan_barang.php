<?php session_start();


include 'db.php';

 $satuan_konversi = $_POST['satuan_konversi'];
 $jumlah_baru = $_POST['jumlah_baru'];
 $kode_barang = $_POST['kode_barang'];

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' ");
 $dataaa = mysqli_fetch_array($queryy);
 $stok = $dataaa['total_sisa'];

 

 $query = $db->query("SELECT konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND kode_produk = '$kode_barang'");
 $data = mysqli_fetch_array($query);

 if ($data['konversi'] == "") {

 $hasil = $jumlah_baru;
 	
 }

 else{

 $hasil = $jumlah_baru * $data['konversi'];

 }

 echo $hasil1 = $stok - $hasil;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>
