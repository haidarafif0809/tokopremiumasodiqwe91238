<?php date_default_timezone_set("Asia/Jakarta");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tokosurya";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

// perintah untuk mengkoneksikan php ke database mysql
<<<<<<< HEAD
$db = new mysqli('localhost','root','','tokosurya');
=======
$db = new mysqli('localhost','root','','toko_surya');
>>>>>>> master


// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


?>