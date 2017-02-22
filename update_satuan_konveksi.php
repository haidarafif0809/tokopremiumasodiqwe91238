<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $select_satuan = stringdoang($_POST['select_satuan']);
    $jenis_select = stringdoang($_POST['jenis_select']);

if ($jenis_select == 'satuan') {

		$query =$db->prepare("UPDATE satuan_konversi SET id_satuan = ?  WHERE id = ?");
		
		$query->bind_param("si",
        $select_satuan, $id);


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