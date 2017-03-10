<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$session_id = session_id();

$query = $db->query("SELECT pelanggan FROM tbs_tukar_poin WHERE session_id = '$session_id' LIMIT 1 ");
$data = mysqli_num_rows($query);

if ($data > 0) {
      
      $sql = mysqli_fetch_array($query);
      echo$pelanggan = $sql['pelanggan'];

}
else
{
  echo 0;
}

//Untuk Memutuskan Koneksi Ke fbsql_database( )e
mysqli_close($db);   

 ?>