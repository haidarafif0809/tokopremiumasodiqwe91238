<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $input_konversi = angkadoang($_POST['input_konversi']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'konversi') {

		$query =$db->prepare("UPDATE satuan_konversi SET konversi = ?  WHERE id = ?");
		
		$query->bind_param("ii",
        $input_konversi, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}


?>