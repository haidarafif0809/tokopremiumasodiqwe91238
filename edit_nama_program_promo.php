<?php 
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);

       $query =$db->prepare("UPDATE program_promo SET nama_program = ?  WHERE id = ?");

       $query->bind_param("si",
       $input_nama, $id);

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