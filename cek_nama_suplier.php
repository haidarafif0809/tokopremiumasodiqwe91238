<?php 
    //memasukan file yang ada pada db.php
    include 'sanitasi.php';
    include 'db.php';

    $nama = stringdoang($_POST['nama']);

    $query = $db->query("SELECT nama FROM suplier WHERE nama = '$nama'");
    $data_kategori = mysqli_num_rows($query);

    if ($data_kategori > 0) {
        echo "1";
    }
    else{
        echo "0";
    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    ?>