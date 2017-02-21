<?php 
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 
    $session_id = $_GET['session_id'];

$query1 = $db->query("SELECT no_faktur_pembelian, jumlah_retur FROM tbs_retur_pembelian WHERE session_id = '$session_id'");
$cek =mysqli_fetch_array($query1);

 $jumlah = $cek['jumlah_retur'];
 $no_faktur = $cek['no_faktur_pembelian'];

    $query2 = $db->query("UPDATE detail_pembelian SET sisa = sisa + '$jumlah' WHERE no_faktur = '$no_faktur'");
    // menghapus data pada tabel tbs_pembelian berdasarkan no_fakturu 
    $query = $db->query("DELETE FROM tbs_retur_pembelian WHERE session_id='$session_id'");
    // logika $query => jika $query benar maka akan menuju ke formpemebelain.php
    // dan jika salah maka akan menampilkan kalimat failed
    
    if ($query == TRUE)
    {
        header('location:form_retur_pembelian.php');
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>