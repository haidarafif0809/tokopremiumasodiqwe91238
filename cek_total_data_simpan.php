<?php 
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$no_faktur = $_POST['no_faktur'];
// menampilakn hasil penjumlah subtotal ALIAS total penjualan dari tabel tbs_penjualan berdasarkan data no faktur
 $query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
 
 // menyimpan data sementara yg ada pada $query
 $data = mysqli_fetch_array($query);
 echo $total = $data['total_penjualan'];

?>