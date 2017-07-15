<?php include 'session_login.php';

//memasukan file db.php
include 'sanitasi.php';
include 'db.php';

//mengirimkan $id menggunakan metode GET
$session_id = session_id();

//menghapus seluruh data yang ada pada tabel tbs penjualan berdasarkan id
$query = $db->query("DELETE FROM tbs_tukar_poin WHERE session_id = '$session_id' AND no_faktur IS NULL ");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
