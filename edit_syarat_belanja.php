<?php 
    // memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $input_syarat = angkadoang($_POST['input_syarat']);

       $query =$db->prepare("UPDATE program_promo SET syarat_belanja = ?  WHERE id = ?");

       $query->bind_param("si",
       $input_syarat, $id);

       $query->execute();

        if (!$query) 
        {
         die('Query Error : '.$db->errno.
         ' - '.$db->error);
        }
        else 
        {

        }

?>