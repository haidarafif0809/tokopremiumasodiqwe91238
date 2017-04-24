<?php session_start();

include 'sanitasi.php';
include 'db.php';
	$session_id = session_id();
	$tanggal = $_GET['tanggal_sekarang'];


$querytb = $db->query("SELECT sum(subtotal) as totale , sum(potongan) as potongane FROM tbs_penjualan WHERE session_id = '$session_id' and tanggal = '$tanggal'");
$idtb = mysqli_fetch_array($querytb);


  echo json_encode($idtb);

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


