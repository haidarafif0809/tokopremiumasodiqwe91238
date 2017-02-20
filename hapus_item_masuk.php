<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$no_faktur = $_POST['no_faktur'];
$user = $_SESSION['user_name'];

 // INSERT HISTORY ITEM MASUK
$item_masuk = $db->query("SELECT * FROM item_masuk WHERE no_faktur = '$no_faktur'");
$data_item_masuk = mysqli_fetch_array($item_masuk);

$insert_item_masuk = $db->query("INSERT INTO history_item_masuk (no_faktur, kode_gudang, tanggal, jam, user, user_edit, tanggal_edit, keterangan, total, user_hapus) VALUES ('$no_faktur','$data_item_masuk[kode_gudang]','$data_item_masuk[tanggal]', '$data_item_masuk[jam]', '$data_item_masuk[user]', '$data_item_masuk[user_edit]','$data_item_masuk[tanggal_edit]','$data_item_masuk[keterangan]', '$data_item_masuk[total]' , '$user')");

// INSERT HISTORY DETAIL ITEM MASUK
$detail_item_masuk = $db->query("SELECT * FROM detail_item_masuk WHERE no_faktur = '$no_faktur'");
while($data_detail_item_masuk = mysqli_fetch_array($detail_item_masuk)){

      $insert_item_masuk = $db->query("INSERT INTO history_detail_item_masuk (no_faktur, tanggal, kode_barang, nama_barang, gudang_item_masuk, jumlah, satuan, harga, subtotal, jam, waktu, user_hapus) VALUES ('$no_faktur', '$data_detail_item_masuk[tanggal]', '$data_detail_item_masuk[kode_barang]', '$data_detail_item_masuk[nama_barang]', '$data_detail_item_masuk[gudang_item_masuk]', '$data_detail_item_masuk[jumlah]', '$data_detail_item_masuk[satuan]', '$data_detail_item_masuk[harga]', '$data_detail_item_masuk[subtotal]', '$data_detail_item_masuk[jam]', '$data_detail_item_masuk[waktu]', '$user')");

} 


if ($insert_item_masuk == TRUE)
{
echo "sukses";
}
else
{
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
