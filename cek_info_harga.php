<?php session_start();


include 'db.php';	

 $kode = $_GET['kode_produk'];

 $query = $db->query("SELECT SUM(hp.sisa) AS jumlah_barang, b.harga_jual,b.nama_barang,b.kode_barang,s.nama as satuan FROM barang b LEFT JOIN satuan s ON b.satuan = s.id LEFT JOIN hpp_masuk hp ON b.kode_barang =  hp.kode_barang WHERE  b.kode_barang = '$kode'");
 $data = mysqli_fetch_array($query);


 	echo json_encode($data);
 
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


