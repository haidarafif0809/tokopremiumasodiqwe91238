<?php session_start();

    include 'db.php';
    include 'sanitasi.php';
    $no_faktur = stringdoang($_POST['no_faktur']);

    $session_id = session_id();

    $query = $db->query("DELETE FROM tbs_stok_opname WHERE no_faktur = '$no_faktur' ");

    
    if ($query == TRUE)
    {
        header('location:stok_opname.php');
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>