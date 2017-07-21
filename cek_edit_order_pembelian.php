<?php session_start();

include 'db.php';

$no_faktur = $_POST['no_faktur'];

$query_tbs = $db->query("SELECT no_faktur_order FROM tbs_pembelian WHERE no_faktur = '$no_faktur' AND no_faktur_order IS NOT NULL");
$row_order = mysqli_num_rows($query_tbs);

if ($row_order > 0){
  echo "1";
}
else {
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>