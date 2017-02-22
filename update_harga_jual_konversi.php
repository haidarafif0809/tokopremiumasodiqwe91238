<?php 

	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    
     $id = angkadoang($_POST['id']);
     $input_harga_jual = angkadoang($_POST['input_harga_jual']);
     

        $query =$db->prepare("UPDATE satuan_konversi SET harga_jual_konversi = ?  WHERE id = ?");
        
        $query->bind_param("ii",
        $input_harga_jual, $id);


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