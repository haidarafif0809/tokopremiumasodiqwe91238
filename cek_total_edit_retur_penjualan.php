<?php 
include 'db.php';

 // mengirim data no faktur menggunakan metode POST
 $no_faktur = $_POST['no_faktur_retur'];

 $query = $db->query("SELECT SUM(subtotal) AS total_retur_penjualan FROM tbs_retur_penjualan WHERE no_faktur_retur = '$no_faktur'");
 $data = mysqli_fetch_array($query);
 $data['total_retur_penjualan'];

 if ($data['total_retur_penjualan'] == "" OR $data['total_retur_penjualan'] == "NULL") {
 	echo $subtotal = 0;
 }
 else{
 	echo $subtotal = $data['total_retur_penjualan'];
 }

//Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db); 

?>