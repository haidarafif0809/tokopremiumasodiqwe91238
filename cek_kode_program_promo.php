<?php

include 'db.php';

$kode = $_POST['kode_program'];

$query = $db->query("SELECT kode_program FROM program_promo WHERE kode_program = '$kode' ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

