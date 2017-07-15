<?php 
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $input_tanggal = stringdoang($_POST['input_tanggal']);

       $query =$db->prepare("UPDATE program_promo SET batas_akhir = ?  WHERE id = ?");

       $query->bind_param("si",
       $input_tanggal, $id);

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