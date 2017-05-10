<?php session_start();
    // memasukan file db.php
    include 'db.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 
    $session_id = session_id();
    $query = $db->query("DELETE FROM tbs_transfer_stok WHERE session_id = '$session_id' AND (no_faktur IS NULL OR no_faktur = '')");

    if ($query == TRUE)
    {
         echo "1";
    }
    else
    {
        echo "0";
    }


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
    ?>