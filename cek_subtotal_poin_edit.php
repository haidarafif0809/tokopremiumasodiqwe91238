<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);

$query = $db->query("SELECT SUM(subtotal_poin) AS subtotal FROM tbs_tukar_poin WHERE no_faktur = '$no_faktur' ");
$sql = mysqli_fetch_array($query);

echo$sql['subtotal'];

//Untuk Memutuskan Koneksi Ke fbsql_database( )e
mysqli_close($db);   

 ?>