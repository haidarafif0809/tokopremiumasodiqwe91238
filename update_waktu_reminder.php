<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_waktu = angkadoang($_POST['input_waktu']);

       $query =$db->prepare("UPDATE setting_waktu_reminder SET waktu = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_waktu, $id);

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