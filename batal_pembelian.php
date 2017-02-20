<?php 
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) session_id, menggunakan metode GET 
    $session_id = $_GET['session_id'];
    // menghapus data pada tabel tbs_pembelian berdasarkan session_id 
    $query = $db->query("DELETE FROM tbs_pembelian WHERE session_id='$session_id'");
   

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>