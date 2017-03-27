<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $kode_flag = stringdoang($_POST['input_tampil']);

		$query =$db->prepare("UPDATE setting_timbangan SET kode_flag = ?  WHERE id = ?");
		
		$query->bind_param("si",
        $kode_flag, $id);


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