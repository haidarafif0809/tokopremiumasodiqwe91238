<?php 

	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $input_harga = angkadoang($_POST['input_harga']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'harga') {

		$query =$db->prepare("UPDATE satuan_konversi SET harga_pokok = ?  WHERE id = ?");
		
		$query->bind_param("ii",
        $input_harga, $id);


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