<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$session_id = session_id();

$query = $db->query("SELECT SUM(subtotal_poin) AS subtotal FROM tbs_tukar_poin WHERE session_id = '$session_id' ");
$sql = mysqli_fetch_array($query);

echo$sql['subtotal'];

//Untuk Memutuskan Koneksi Ke fbsql_database( )e
mysqli_close($db);   

 ?>