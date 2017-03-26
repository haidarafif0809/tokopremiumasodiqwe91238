<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_GET['no_faktur']);
$pelanggan = angkadoang($_GET['pelanggan']);
$tanggal = stringdoang($_GET['tanggal']);


$perintah2 = $db->query("DELETE FROM tbs_tukar_poin WHERE no_faktur = '$no_faktur'");



/// INSERT HISTORY TUKAR POIN
    $history_a = "INSERT INTO tbs_tukar_poin(no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu)  SELECT '$no_faktur', pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu FROM detail_tukar_poin WHERE no_faktur = '$no_faktur'  ";


        if ($db->query($history_a) === TRUE) {
        } 

        else {
        echo "Error: " . $history_a . "<br>" . $db->error;
        }


 header ('location:edit_tukar_poin.php?no_faktur='.$no_faktur.'&pelanggan='.$pelanggan.'&tanggal='.$tanggal.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>