<?php 

include 'db.php';

$kode_akun = $_POST['kode_akun'];

$query = $db->query("SELECT kode_daftar_akun FROM daftar_akun WHERE kode_daftar_akun = '$kode_akun'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

