<?php 
    // memasukan file db.php
    include 'db.php';


    $session_id = $_GET['session_id'];

$query1 = $db->query("SELECT no_faktur_penjualan, jumlah_retur FROM tbs_retur_penjualan WHERE session_id = '$session_id'");
$cek =mysqli_fetch_array($query1);

 $jumlah = $cek['jumlah_retur'];
 $no_faktur = $cek['no_faktur_penjualan'];

    $query2 = $db->query("UPDATE detail_penjualan SET sisa = sisa + '$jumlah' WHERE no_faktur = '$no_faktur'");


    $query = $db->query("DELETE FROM tbs_retur_penjualan WHERE session_id='$session_id'");


    
    if ($query == TRUE)
    {
        header('location:form_retur_penjualan.php');
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>