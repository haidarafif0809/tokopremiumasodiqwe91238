<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

    $username = stringdoang($_POST['username']);
    $password = $_POST['password'];


   $querymaster =  $db->query("SELECT username, password FROM user WHERE username = '$username' AND otoritas = 'Admin'");
   $data = mysqli_fetch_array($querymaster);
   $jumlah = mysqli_num_rows($querymaster);

   $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjxl.0t1kA8pw9dMXTpOq';

    
    if ($jumlah == 1 )
        {
                $passwordku = $data['password'];

                if (password_verify($password,$passwordku)) 
                {
                echo "1";
                }
                else
                {
                echo "0";
                }


         }

                
  



?>

