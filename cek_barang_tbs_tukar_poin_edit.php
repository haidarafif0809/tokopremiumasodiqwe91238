<?php session_start();
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$kode_barang = stringdoang($_POST['kode_barang']);

$query = $db->query("SELECT kode_barang FROM tbs_tukar_poin WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' ");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo 1;
  
}
else {

}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

