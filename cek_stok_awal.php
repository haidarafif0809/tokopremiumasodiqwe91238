<?php session_start();

include 'db.php';

 $kode_barang = $_POST['kode_barang'];

 $query = $db->query("SELECT * FROM stok_awal WHERE kode_barang = '$kode_barang'");

$data = mysqli_num_rows($query);

 if ($data > 0 ) {
 	echo "1";

 } 

 else {

 }
 


mysqli_close($db); 
        

  ?>
