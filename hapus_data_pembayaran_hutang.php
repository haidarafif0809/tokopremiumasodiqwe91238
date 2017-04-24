<?php session_start();

// memsukan file db,php
include 'db.php';


$id = $_POST['id'];
$user = $_SESSION['user_name'];
$no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];




// INSERT HISTORY PEMBAYARAN HUTANG
$pembayaran_hutang = $db->query("SELECT * FROM pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
$data_pembayaran_hutang = mysqli_fetch_array($pembayaran_hutang);

$insert_pembayaran_hutang = $db->query("INSERT INTO history_pembayaran_hutang (no_faktur_pembayaran, tanggal, jam, nama_suplier, keterangan, total, user_buat, user_edit, tanggal_edit, dari_kas, user_hapus) VALUES ('$no_faktur_pembayaran','$data_pembayaran_hutang[tanggal]','$data_pembayaran_hutang[jam]','$data_pembayaran_hutang[nama_suplier]', '$data_pembayaran_hutang[keterangan]','$data_pembayaran_hutang[total]','$data_pembayaran_hutang[user_buat]','$data_pembayaran_hutang[user_edit]','$data_pembayaran_hutang[tanggal_edit]','$data_pembayaran_hutang[dari_kas]', '$user')");


// INSERT HISTORY DETAIL PEMBAYARAN HUTANG
$detail_pembayaran_hutang = $db->query("SELECT * FROM detail_pembayaran_hutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");
while($data_detail_pembayaran_hutang = mysqli_fetch_array($detail_pembayaran_hutang)){

	$insert_pembayaran_hutang = $db->query("INSERT INTO history_detail_pembayaran_hutang (no_faktur_pembayaran, no_faktur_pembelian, tanggal, tanggal_jt, kredit, potongan, total, jumlah_bayar, user_hapus) VALUES ('$no_faktur_pembayaran', '$data_detail_pembayaran_hutang[no_faktur_pembelian]', '$data_detail_pembayaran_hutang[tanggal]', '$data_detail_pembayaran_hutang[tanggal_jt]', '$data_detail_pembayaran_hutang[kredit]', '$data_detail_pembayaran_hutang[potongan]', '$data_detail_pembayaran_hutang[total]', '$data_detail_pembayaran_hutang[jumlah_bayar]', '$user')");

}

if ($insert_pembayaran_hutang == TRUE)
{

echo "sukses";

}
else
{

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
