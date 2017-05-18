<?php 

include 'db.php';

$kode_grup_akun = $_POST['kode_akun'];

$query_row = $db->query("SELECT grup_akun FROM daftar_akun WHERE grup_akun = '$kode_grup_akun'");
$jumlah_row = mysqli_num_rows($query_row);

$query_row_grup = $db->query("SELECT parent FROM grup_akun WHERE parent = '$kode_grup_akun'");
$jumlah_row_grup = mysqli_num_rows($query_row_grup);


if ($jumlah_row > 0 OR $jumlah_row_grup > 0){
  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

