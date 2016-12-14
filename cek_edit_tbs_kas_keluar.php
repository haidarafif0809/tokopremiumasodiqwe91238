<?php 

include 'db.php';

$keakun = $_POST['keakun'];
$no_faktur = $_POST['no_faktur'];

$select = $db->query("SELECT * FROM tbs_kas_keluar WHERE no_faktur = '$no_faktur' AND ke_akun = '$keakun'");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0) {
	echo "ya";
}
else{

}

 ?>