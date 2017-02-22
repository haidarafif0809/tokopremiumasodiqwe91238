<?php 
include 'db.php';
include 'sanitasi.php';

$nama = stringdoang($_POST['nama']);

$select = $db->query("SELECT nama FROM biaya_admin WHERE nama = '$nama'");
$jumlah = mysqli_num_rows($select);

if ($jumlah > 0){
  echo "1";
}
else {

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
        
        

 ?>