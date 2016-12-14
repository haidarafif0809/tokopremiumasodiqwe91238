<?php 

include 'db.php';

$kode_meja = $_POST['kode_meja'];

$query = $db->query("SELECT * FROM meja WHERE kode_meja = '$kode_meja'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
 ?>

