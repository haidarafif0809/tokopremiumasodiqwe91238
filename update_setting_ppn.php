<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $select_ppn = stringdoang($_POST['select_ppn']);

		$query =$db->prepare("UPDATE perusahaan SET setting_ppn = ?  WHERE id = ?");
		
		$query->bind_param("si",
        $select_ppn, $id);


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