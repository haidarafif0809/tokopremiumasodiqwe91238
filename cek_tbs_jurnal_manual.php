<?php session_start();

include 'db.php';

 $kode_akun = $_POST['kode_akun'];
 $session_id = $_POST['session_id'];

 $query = $db->query("SELECT * FROM tbs_jurnal WHERE kode_akun_jurnal = '$kode_akun' AND session_id = '$session_id'");

$data = mysqli_num_rows($query);

 if ($data > 0 ) {
 	echo "1";

 } 

 else {

 }
 


mysqli_close($db); 
        

  ?>
