<?php 

    include 'sanitasi.php';
    include 'db.php';

    $id = angkadoang($_POST['id']);
    $input_nama = stringdoang($_POST['input_nama']);
    $jenis_nama = angkadoang($_POST['jenis_nama']);


    if ($jenis_nama == 'nama_gudang') {

       $query =$db->prepare("UPDATE gudang SET nama_gudang = ?  WHERE id = ?");

       $query->bind_param("ii",
        $jenis_nama, $id);


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

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>
