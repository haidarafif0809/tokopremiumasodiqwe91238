<?php 

include 'db.php';

$nama = $_POST['nama'];

$query = $db->query("SELECT * FROM hak_otoritas WHERE nama = '$nama'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
 ?>

