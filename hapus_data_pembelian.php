<?php session_start();

// memsukan file db,php
include 'db.php'; 


$id = $_POST['id'];
$no_faktur = $_POST['no_faktur'];
$user =  $_SESSION['user_name'];

// INSERT HISTORY PEMBELIAN
$pembelian = $db->query("SELECT * FROM pembelian WHERE no_faktur = '$no_faktur'");
$data_pembelian = mysqli_fetch_array($pembelian);

$insert_pembelian = $db->query("INSERT INTO history_pembelian (no_faktur, kode_gudang, suplier, total, tanggal, tanggal_jt, jam, user, status, potongan, tax, sisa, kredit, nilai_kredit, cara_bayar, tunai, ppn, status_beli_awal, user_hapus) VALUES ('$no_faktur', '$data_pembelian[kode_gudang]', '$data_pembelian[suplier]', '$data_pembelian[total]','$data_pembelian[tanggal]','$data_pembelian[tanggal_jt]','$data_pembelian[jam]','$data_pembelian[user]', '$data_pembelian[status]','$data_pembelian[potongan]','$data_pembelian[tax]','$data_pembelian[sisa]','$data_pembelian[kredit]','$data_pembelian[nilai_kredit]', '$data_pembelian[cara_bayar]','$data_pembelian[tunai]','$data_pembelian[ppn]', '$data_pembelian[status_beli_awal]', '$user')");


// INSERT HISTORY DETAIL PEMBELIAN
$detail_pembelian = $db->query("SELECT * FROM detail_pembelian WHERE no_faktur = '$no_faktur'");
while($data_detail_pembelian = mysqli_fetch_array($detail_pembelian)){

	$insert_pembelian = $db->query("INSERT INTO history_detail_pembelian (no_faktur, tanggal, jam, waktu, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, status, sisa, user_hapus) VALUES ('$no_faktur', '$data_detail_pembelian[tanggal]', '$data_detail_pembelian[jam]', '$data_detail_pembelian[waktu]', '$data_detail_pembelian[kode_barang]', '$data_detail_pembelian[nama_barang]', '$data_detail_pembelian[jumlah_barang]', '$data_detail_pembelian[satuan]', '$data_detail_pembelian[harga]', '$data_detail_pembelian[subtotal]', '$data_detail_pembelian[potongan]', '$data_detail_pembelian[tax]', '$data_detail_pembelian[status]', '$data_detail_pembelian[sisa]', '$user')");

}




if ($insert_pembelian == TRUE)
{

echo "sukses";

}
else
{
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
