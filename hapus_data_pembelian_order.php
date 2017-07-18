<?php session_start();

// memsukan file db,php
include 'db.php';


$id = $_POST['id'];
$no_faktur = $_POST['no_faktur'];
$petugas =  $_SESSION['nama'];

// INSERT HISTORY ORDER PEMBELIAN
$pembelian = $db->query("SELECT kode_gudang, suplier, total, tanggal, jam, user, status_order, keterangan, user_edit FROM pembelian_order WHERE no_faktur_order = '$no_faktur'");
$data_pembelian = mysqli_fetch_array($pembelian);


$insert_pembelian22 = "INSERT INTO history_pembelian_order (no_faktur_order, kode_gudang, suplier, total, tanggal, jam, user, status_order,keterangan, user_edit, user_hapus) VALUES ('$no_faktur','$data_pembelian[kode_gudang]', '$data_pembelian[suplier]', '$data_pembelian[total]','$data_pembelian[tanggal]','$data_pembelian[jam]','$data_pembelian[user]','$data_pembelian[status_order]','$data_pembelian[keterangan]','$data_pembelian[user_edit]', '$petugas')";
if ($db->query($insert_pembelian22) === TRUE) {
        } 

        else {
        echo "Error: " . $insert_pembelian22 . "<br>" . $db->error;
        }


// INSERT HISTORY DETAIL ORDER PEMBELIAN
$detail_pembelian = $db->query("SELECT * FROM detail_pembelian_order WHERE no_faktur_order = '$no_faktur'");
while($data_detail_pembelian = mysqli_fetch_array($detail_pembelian)){

	$insert_pembelian33 = $db->query("INSERT INTO history_detail_pembelian_order (no_faktur_order,kode_barang, nama_barang, jumlah_barang,satuan, harga, subtotal, potongan, tax,tanggal,jam,asal_satuan, user_hapus) VALUES ('$no_faktur', '$data_detail_pembelian[kode_barang]', '$data_detail_pembelian[nama_barang]', '$data_detail_pembelian[jumlah_barang]', '$data_detail_pembelian[satuan]', '$data_detail_pembelian[harga]', '$data_detail_pembelian[subtotal]', '$data_detail_pembelian[potongan]', '$data_detail_pembelian[tax]', '$data_detail_pembelian[tanggal]', '$data_detail_pembelian[jam]', '$data_detail_pembelian[asal_satuan]', '$petugas')");

}



$query5 = $db->query("DELETE FROM tbs_pembelian_order WHERE no_faktur_order = '$no_faktur'");


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
