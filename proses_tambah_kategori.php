<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';
 
    // mengirim data menggunakan metode POST


    $perintah = $db->prepare("INSERT INTO kategori (id,nama_kategori) VALUES (?,?)");

    $perintah->bind_param("ss",
        $id, $nama);
        
        $id = stringdoang($_POST['id']);
        $nama = stringdoang($_POST['nama']); 
    
    $perintah->execute();



if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo "sukses";
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>