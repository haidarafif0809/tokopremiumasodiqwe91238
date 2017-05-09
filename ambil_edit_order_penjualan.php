<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = session_id();


$no_faktur_order = stringdoang($_POST['no_faktur_order']);
$no_faktur = stringdoang($_POST['no_faktur']);


$perintah3 = $db->query("SELECT no_faktur FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur_order' ");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur_order'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur_order'");
while ($data = mysqli_fetch_array($perintah)){

if ($data['satuan'] == $data['asal_satuan']) {



$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax,tanggal,jam,no_faktur_order) VALUES ( '$no_faktur', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah_barang]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[tanggal]', '$data[jam]','$no_faktur_order')");

}

else{

$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
$data_konversi = mysqli_fetch_array($konversi);

$jumlah_produk = $data['jumlah_barang'] / $data_konversi['konversi'];
$harga = $data['harga'] * $data['jumlah_barang'];


$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax,tanggal,jam,no_faktur_order) VALUES ( '$no_faktur', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_produk', '$data[satuan]', '$harga', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[tanggal]', '$data[jam]','$no_faktur_order')");


}


}


$update_status_order = $db->query("UPDATE penjualan_order SET status_order = 'Masuk TBS' WHERE no_faktur_order = '$no_faktur_order' ");

$update_status_order = $db->query("UPDATE tbs_fee_produk SET no_faktur = '$no_faktur' WHERE no_faktur_order = '$no_faktur_order' ");

//Untuk Memutuskan Koneksi Ke Database
 ?>
