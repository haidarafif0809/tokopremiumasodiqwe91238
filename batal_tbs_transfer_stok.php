<?php session_start();
    // memasukan file db.php
    include 'db.php';
    include 'sanitasi.php';
    // mengirim data(file) no_faktur, menggunakan metode GET 
    $session_id = session_id();
    if (isset($_POST['no_faktur'])) {
            
            $no_faktur = stringdoang($_POST['no_faktur']);
            
            $query = $db->query("DELETE FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur' AND (session_id IS NULL OR session_id = '')");
    }
    else{

            $query = $db->query("DELETE FROM tbs_transfer_stok WHERE session_id = '$session_id' AND (no_faktur IS NULL OR no_faktur = '')");
    }

    
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