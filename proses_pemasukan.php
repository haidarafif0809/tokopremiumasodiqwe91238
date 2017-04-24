<?php 
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
            
            
        $perintah = $db->prepare("INSERT INTO pemasukan (id,nama) VALUES (?,?)");
            
        $perintah->bind_param("is",
        $id, $nama);
            
        $id = angkadoang($_POST['id']);
        $nama = stringdoang($_POST['nama']);
            
        $perintah->execute();
            
            
        if ($perintah == TRUE)
        {
            
        echo "sukses";
        }
        
        else
        {
            
        }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>