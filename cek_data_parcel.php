<?php 

include 'db.php';
include 'sanitasi.php';

$kode_parcel = stringdoang($_POST['kode_parcel']);

$query = $db->query("SELECT kode_parcel, nama_parcel FROM perakitan_parcel WHERE kode_parcel = '$kode_parcel'");
$jumlah = mysqli_num_rows($query);

echo $jumlah;

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

