<?php 

include 'db.php';

$kode_barang = $_POST['kode_barang'];

$query = $db->query("SELECT kode_barang FROM barang WHERE kode_barang = '$kode_barang'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

