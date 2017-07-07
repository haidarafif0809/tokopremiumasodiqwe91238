<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_tampil = angkadoang($_POST['input_tampil']);

		$query =$db->prepare("UPDATE perusahaan SET nilai_ppn = ?  WHERE id = ?");
		
		$query->bind_param("ii",
        $input_tampil, $id);


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