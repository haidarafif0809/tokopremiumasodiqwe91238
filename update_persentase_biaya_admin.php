<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_persen = stringdoang($_POST['input_persen']);

       $query =$db->prepare("UPDATE biaya_admin SET persentase = ?  WHERE id = ?");

       $query->bind_param("si",
        $input_persen, $id);


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