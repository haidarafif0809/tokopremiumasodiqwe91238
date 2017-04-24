<?php session_start();

//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

//mengirimkan $id menggunakan metode POST
$no_faktur = stringdoang($_POST['no_faktur']);
$id = angkadoang($_POST['id']);
$user = $_SESSION['nama'];


$query = $db->query("SELECT * FROM tukar_poin WHERE no_faktur = '$no_faktur'");
$data = mysqli_fetch_array($query);


/// INSERT HISTORY TUKAR POIN
    $history_c = "INSERT INTO history_tukar_poin(no_faktur, pelanggan, poin_pelanggan_terakhir, total_poin, sisa_poin, user, user_edit, tanggal, jam, waktu_input, waktu_edit, keterangan, user_hapus) VALUES ('$data[no_faktur]', '$data[pelanggan]', '$data[poin_pelanggan_terakhir]', '$data[total_poin]', '$data[sisa_poin]', '$data[user]', '$data[user_edit]', '$data[tanggal]', '$data[jam]', '$data[waktu_input]', '$data[waktu_edit]', '$data[keterangan]', '$user' )";


        if ($db->query($history_c) === TRUE) {
        } 

        else {
        echo "Error: " . $history_c . "<br>" . $db->error;
        }



$sql = $db->query("SELECT * FROM detail_tukar_poin WHERE no_faktur = '$no_faktur'");
while ($row = mysqli_fetch_array($sql)) {
   
       /// INSERT HISTORY DETAIL TUKAR POIN
    $history_d = "INSERT INTO history_detail_tukar_poin(no_faktur, pelanggan, kode_barang, nama_barang, satuan, jumlah_barang, poin, subtotal_poin, tanggal, jam, waktu, user_hapus) VALUES ('$row[no_faktur]', '$row[pelanggan]', '$row[kode_barang]', '$row[nama_barang]', '$row[satuan]', '$row[jumlah_barang]', '$row[poin]', '$row[subtotal_poin]', '$row[tanggal]', '$row[jam]', '$row[waktu]', '$user')";

        if ($db->query($history_d) === TRUE) {
        } 

        else {
        echo "Error: " . $history_d . "<br>" . $db->error;
        }

};





//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
