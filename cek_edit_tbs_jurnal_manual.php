<?php session_start();

include 'db.php';
include 'sanitasi.php';


 $kode_akun = stringdoang($_POST['kode_akun']);

 $no_faktur = stringdoang($_POST['no_faktur']);

 $query = $db->query("SELECT * FROM tbs_jurnal WHERE kode_akun_jurnal = '$kode_akun' AND no_faktur = '$no_faktur'");

$data = mysqli_num_rows($query);

 if ($data > 0 ) {
 	echo 1;

 } 

else 
{
	echo 0;
 }
 


mysqli_close($db); 
        

  ?>
