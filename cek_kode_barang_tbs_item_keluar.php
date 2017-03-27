<?php  session_start();

include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
$kode_barang = stringdoang($_POST['kode_barang']);

$query = $db->query("SELECT kode_barang FROM tbs_item_keluar WHERE kode_barang = '$kode_barang' AND session_id = '$session_id'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

echo "0";
}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

