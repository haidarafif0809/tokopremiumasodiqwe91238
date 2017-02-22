<?php 

include 'db.php';

$user = $_POST['user'];

$query = $db->query("SELECT * FROM user WHERE username = '$user'");
$jumlah = mysqli_num_rows($query);


if ($jumlah > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        

 ?>

