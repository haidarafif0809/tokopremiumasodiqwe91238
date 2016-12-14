<?php 

include 'db.php';

$keakun = $_POST['keakun'];
$session_id = $_POST['session_id'];

$select = $db->query("SELECT * FROM tbs_kas_keluar WHERE session_id = '$session_id' AND ke_akun = '$keakun'");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0) {
	echo "ya";
}
else{

}

 ?>