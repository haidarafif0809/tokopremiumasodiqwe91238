<?php 
    //memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';

    $id = stringdoang($_POST['id']);
    $nama = stringdoang($_POST['nama']);
    $alamat= stringdoang($_POST['alamat']);
    $no_telp = angkadoang($_POST['no_telp']);

    $perintah = $db->prepare("INSERT INTO suplier (id,nama,alamat,no_telp)
			VALUES (?,?,?,?)");

    $perintah->bind_param("ssss",
        $id, $nama, $alamat, $no_telp);


    $perintah->execute();

if (!$perintah) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   echo "sukses";;
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>