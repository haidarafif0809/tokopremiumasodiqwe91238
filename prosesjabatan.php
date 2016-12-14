<?php 
    // memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';
 
    // mengirim data menggunakan metode POST


    $perintah = $db->prepare("INSERT INTO jabatan (id,nama,wewenang) VALUES (?,?,?)");

    $perintah->bind_param("sss",
        $id, $nama, $wewenang);
        
        $id = stringdoang($_POST['id']);
        $nama = stringdoang($_POST['nama']); 
        $wewenang = stringdoang($_POST['wewenang']);   
    
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