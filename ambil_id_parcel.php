<?php session_start();

 include 'db.php';

 $kode_parcel_cari = $_GET['kode_parcel_cari'];

 $sum_detail_parcel = $db->query("SELECT id FROM perakitan_parcel WHERE kode_parcel = '$kode_parcel_cari'");
 $data = mysqli_fetch_array($sum_detail_parcel);



echo json_encode($data);
exit;

//Untuk Memutuskan Koneksi Ke Database
 mysqli_close($db);
        
?>