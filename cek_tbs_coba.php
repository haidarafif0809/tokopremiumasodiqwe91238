<?php 

include 'db.php';

$no_faktur = $_POST['no_faktur'];

$query = $db->query("SELECT * FROM tbs_pembelian WHERE no_faktur = '$no_faktur'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

