<?php session_start();

//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';


$id_parcel = $_POST['id_parcel'];
$session_id = $_POST['session_id'];

    $query = $db->query("SELECT * FROM tbs_parcel WHERE session_id = '$session_id' AND id_parcel = '$id_parcel'");
    while ($data = mysqli_fetch_array($query))
    {
        $query2 = $db->query("INSERT INTO detail_perakitan_parcel (id_parcel, id_produk, jumlah_produk)
        VALUES ('$data[id_parcel]','$data[id_produk]','$data[jumlah_produk]')");
    }


    $query3 = $db->query("DELETE  FROM tbs_parcel WHERE session_id = '$session_id' AND id_parcel = '$id_parcel' ");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>