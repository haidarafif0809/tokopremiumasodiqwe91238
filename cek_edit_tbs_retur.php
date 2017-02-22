<?php 

include 'db.php';

$no_faktur_retur = $_POST['no_faktur_retur'];

$query = $db->query("SELECT * FROM tbs_retur_pembelian WHERE no_faktur_retur = '$no_faktur_retur'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

