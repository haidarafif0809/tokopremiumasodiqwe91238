<?php 
//memasukan file db.php
include 'db.php';

$id = $_POST['id'];

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_parcel WHERE id = '$id'");


if ($query == TRUE)
{
echo "1";
}
else
{
	
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
