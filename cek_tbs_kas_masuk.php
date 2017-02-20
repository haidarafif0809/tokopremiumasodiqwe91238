<?php 

include 'db.php';

$dariakun = $_POST['dariakun'];
$session_id = $_POST['session_id'];

$select = $db->query("SELECT * FROM tbs_kas_masuk WHERE session_id = '$session_id' AND dari_akun = '$dariakun'");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0) {
	echo "ya";
}
else{

}

 ?>