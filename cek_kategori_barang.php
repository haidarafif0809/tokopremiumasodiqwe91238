<?php 
include 'db.php';

$kategori = $_POST['kategori'];

$query = $db->query("SELECT * FROM barang WHERE kategori = '$kategori'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);      
?>

