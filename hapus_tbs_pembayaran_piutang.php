<?php 
include 'db.php';

$id = $_POST['id'];

$query = $db->query("DELETE FROM tbs_pembayaran_piutang WHERE id = '$id'");

if ($query == TRUE)
{
	echo "sukses";
}
else
{

}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
