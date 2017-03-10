<?php session_start();


include 'db.php';

 $kode_barang = $_GET['kode_barang'];
 

 $query = $db->query("SELECT nama_barang, id FROM barang WHERE kode_barang = '$kode_barang' ");
 $data = mysqli_fetch_array($query);


 echo json_encode($data);



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


