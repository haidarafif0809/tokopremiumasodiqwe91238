<?php 

// memasukan file db.php
include 'db.php';

//mengirim data $id menggunakan metode GET
$id = $_POST['id'];

//menghapus seluruh data yang ada pada tabel suplier berdasarkan id
$query = $db->query("DELETE FROM suplier WHERE id = '$id'");

//jika $query benar maka akan menuju file suplier.php , jika salah maka failed
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
