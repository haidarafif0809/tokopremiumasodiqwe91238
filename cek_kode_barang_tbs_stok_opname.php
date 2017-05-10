<?php session_start();
include 'db.php';
include 'sanitasi.php';

$session_id = session_id();


$query = $db->query("SELECT kode_barang FROM tbs_stok_opname WHERE session_id = '$session_id' AND (no_faktur  = '' OR no_faktur IS NULL) ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

