<?php 

include 'db.php';
include 'sanitasi.php';

$barcode = stringdoang($_POST['barcode']);

$query = $db->query("SELECT kode_barcode FROM satuan_konversi WHERE kode_barcode = '$barcode'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

