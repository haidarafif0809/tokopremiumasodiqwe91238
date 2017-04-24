<?php 
// memasukan file db.php
include 'db.php';
// mengirim data(file) no_faktur, menggunakan metode GET 
$no_faktur = $_GET['no_faktur'];
// menghapus data pada tabel tbs_pembelian berdasarkan no_faktur 
$query = $db->query("DELETE FROM tbs_item_masuk WHERE no_faktur = '$no_faktur'");


mysqli_close($db);

?>