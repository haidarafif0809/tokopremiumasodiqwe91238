<?php session_start();

include 'db.php';
include 'sanitasi.php';

$tanggal_sekarang = date('Y-m-d');

$queryprogram = $db->query("SELECT batas_akhir FROM program_promo WHERE batas_akhir >= '$tanggal_sekarang'");

$program = mysqli_num_rows($queryprogram);
if ($program > 0 ) {
    echo 1;
}

mysqli_close($db); 

?>