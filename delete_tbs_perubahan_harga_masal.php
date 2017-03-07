<?php 
//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
	 $id = $_POST['id'];
	 $kode_barang = $_POST['kode_barang'];

 // INSERT HISTORY KAS MASUK
$delete = $db->query("DELETE FROM tbs_perubahan_harga_masal WHERE id = '$id' AND kode_barang = '$kode_barang'");

//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($delete == TRUE)
{

echo "1";
}
else
{
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
