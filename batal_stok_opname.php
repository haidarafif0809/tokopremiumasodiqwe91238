<?php 

    include 'db.php';

    $session_id = $_GET['session_id'];

    $query = $db->query("DELETE FROM tbs_stok_opname WHERE no_faktur  = '' OR no_faktur IS NULL ");

    
    if ($query == TRUE)
    {
        header('location:form_stok_opname.php');
    }
    else
    {
        echo "failed";
    }

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
    ?>