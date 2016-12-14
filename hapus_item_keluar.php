<?php session_start();

//mekeluarkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$no_faktur = $_POST['no_faktur'];
$user = $_SESSION['user_name'];

 // INSERT HISTORY ITEM KELUAR
$item_keluar = $db->query("SELECT * FROM item_keluar WHERE no_faktur = '$no_faktur'");
$data_item_keluar = mysqli_fetch_array($item_keluar);

$insert_item_keluar = $db->query("INSERT INTO history_item_keluar (no_faktur, kode_gudang, tanggal, jam, user, user_edit, tanggal_edit, keterangan, total, user_hapus) VALUES ('$no_faktur','$data_item_keluar[kode_gudang]','$data_item_keluar[tanggal]', '$data_item_keluar[jam]', '$data_item_keluar[user]', '$data_item_keluar[user_edit]','$data_item_keluar[tanggal_edit]','$data_item_keluar[keterangan]', '$data_item_keluar[total]' , '$user')");

// INSERT HISTORY DETAIL ITEM KELUAR
$detail_item_keluar = $db->query("SELECT * FROM detail_item_keluar WHERE no_faktur = '$no_faktur'");
while($data_detail_item_keluar = mysqli_fetch_array($detail_item_keluar)){

      $insert_item_keluar = $db->query("INSERT INTO history_detail_item_keluar (no_faktur, tanggal, jam, kode_barang, nama_barang, gudang_item_keluar, jumlah, satuan, harga, subtotal, user_hapus) VALUES ('$no_faktur', '$data_detail_item_keluar[tanggal]', '$data_detail_item_keluar[jam]', '$data_detail_item_keluar[kode_barang]', '$data_detail_item_keluar[nama_barang]', '$data_detail_item_keluar[gudang_item_keluar]', '$data_detail_item_keluar[jumlah]', '$data_detail_item_keluar[satuan]', '$data_detail_item_keluar[harga]', '$data_detail_item_keluar[subtotal]', '$user')");

} 
          

//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($insert_item_keluar == TRUE)
{
echo "sukses";
}
else
{
  
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
