<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = stringdoang($_GET['no_faktur']);
$suplier = stringdoang($_GET['suplier']);
$nama_gudang = stringdoang($_GET['nama_gudang']);
$kode_gudang = stringdoang($_GET['kode_gudang']);

$query_cek_tbs = $db->query("SELECT no_faktur_order FROM tbs_pembelian_order WHERE no_faktur_order = '$no_faktur'");
$jumlah_cek_tbs = mysqli_num_rows($query_cek_tbs);

if ($jumlah_cek_tbs > 0){
	$query_hapus_tbs = $db->query("DELETE FROM tbs_pembelian_order WHERE no_faktur_order = '$no_faktur'");
}

$query_detail = $db->query("SELECT * FROM detail_pembelian_order WHERE no_faktur_order = '$no_faktur'");
	while ($data = mysqli_fetch_array($query_detail)){

		if ($data['satuan'] == $data['asal_satuan']) {

			$insert_tbs = $db->query("INSERT INTO tbs_pembelian_order (no_faktur_order, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax) VALUES ( '$data[no_faktur_order]', '$data[kode_barang]', '$data[nama_barang]', '$data[jumlah_barang]', '$data[satuan]', '$data[harga]', '$data[subtotal]', '$data[potongan]', '$data[tax]')");

		}

		else{

			$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
			$data_konversi = mysqli_fetch_array($konversi);

			$jumlah_produk = $data['jumlah_barang'] / $data_konversi['konversi'];
			$harga = $data['harga'] * $data['jumlah_barang'];

			$insert_tbs = $db->query("INSERT INTO tbs_pembelian_order (no_faktur_order, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax) VALUES ( '$data[no_faktur_order]', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_produk', '$data[satuan]', '$harga', '$data[subtotal]', '$data[potongan]', '$data[tax]')");

		}


	}



 header ('location:form_edit_order_pembelian.php?no_faktur='.$no_faktur.'&suplier='.$suplier.'&nama_gudang='.$nama_gudang.'&kode_gudang='.$kode_gudang.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


