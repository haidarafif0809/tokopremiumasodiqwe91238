<?php 
include 'sanitasi.php';
include 'db.php';

$nama = stringdoang($_POST['nama']);

$query = $db->query("SELECT COUNT(nama) AS jumlah_data FROM satuan WHERE nama = '$nama'");
$jumlah = mysqli_fetch_array($query);

if ($jumlah['jumlah_data'] > 0){

  echo 1;
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>