<?php     session_start();

    include 'sanitasi.php';
    include 'db.php';

    $username = stringdoang($_POST['username']);
    $password = $_POST['password'];


   $querymaster =  $db->query("SELECT username, password FROM user WHERE username = '$username' AND otoritas = 'Pimpinan'");
   $data = mysqli_fetch_array($querymaster);



   $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjxl.0t1kA8pw9dMXTpOq';

    
    if ($data == TRUE )
        {
                $passwordku = $data['password'];

                if (password_verify($password,$passwordku)) 
                {

                echo "sukses";
 
                }
                else
                {
                echo "Gagal Login";
                }


         }       
                
  



?>