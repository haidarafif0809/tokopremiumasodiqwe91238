<?php 

include 'db.php';
include_once 'sanitasi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = $db->query("SELECT password FROM user WHERE username = '$username'");
$data = mysqli_fetch_array($query);


                 $passwordku = $data['password'];

                if (password_verify($password,$passwordku)) 
                {

                echo "1";
                
                }
                else
                {
                	echo "0";
                }


mysqli_close($db);
        
 ?>

