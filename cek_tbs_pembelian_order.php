<?php 

include 'db.php';

$session_id = $_POST['session_id'];

$query_order = $db->query("SELECT session_id FROM tbs_pembelian_order WHERE session_id = '$session_id'");
$jumlah_order = mysqli_num_rows($query_order);


if ($jumlah_order > 0){
  echo "1";
}
else {
	echo "0";
}

 //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 

?>