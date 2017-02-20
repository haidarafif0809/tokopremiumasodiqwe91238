<?php 

include 'db.php';

$kode_pelanggan = $_POST['kode_pelanggan'];

$query = $db->query("SELECT * FROM pelanggan WHERE kode_pelanggan = '$kode_pelanggan'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
 ?>

