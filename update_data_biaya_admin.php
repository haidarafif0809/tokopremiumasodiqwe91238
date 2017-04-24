<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);

if ($jenis_edit == 'nama_biaya_admin') {

       $query =$db->prepare("UPDATE biaya_admin SET nama = ?  WHERE id = ?");

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

}


 ?>