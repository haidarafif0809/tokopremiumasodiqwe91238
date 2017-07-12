<?php 
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $select_jenis = stringdoang($_POST['select_jenis']);

       $query =$db->prepare("UPDATE program_promo SET jenis_bonus = ?  WHERE id = ?");

       $query->bind_param("si",
       $select_jenis, $id);

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