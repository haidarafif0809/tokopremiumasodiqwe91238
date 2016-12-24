<?php 

include 'db.php';

$session_id = $_POST['session_id'];

$query = $db->query("SELECT * FROM tbs_retur_pembelian WHERE session_id = '$session_id' AND no_faktur_retur = ''");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

