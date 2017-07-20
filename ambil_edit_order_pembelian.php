<?php session_start();
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$no_faktur_order = stringdoang($_POST['no_faktur_order']);

$query_select_tbs = $db->query("SELECT no_faktur_order FROM tbs_pembelian WHERE no_faktur_order = '$no_faktur_order' ");
$data_select_tbs = mysqli_num_rows($query_select_tbs);

	if ($data_select_tbs > 0){
		$query_hapus_tbs = $db->query("DELETE FROM tbs_pembelian WHERE no_faktur_order = '$no_faktur_order'");
	}

$query_select_detail = $db->query("SELECT satuan, asal_satuan, no_faktur_order, tanggal, jam FROM detail_pembelian_order WHERE no_faktur_order = '$no_faktur_order'");
$data_select_detail = mysqli_fetch_array($query_select_detail);

if ($data_select_detail['satuan'] == $data_select_detail['asal_satuan']) {
	
	//INSERT DARI DETAIL pembelian ORDER KE TBS pembelian
		$insert_tbs_pembelian = "INSERT INTO tbs_pembelian (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, no_faktur_order) SELECT '$no_faktur', kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, '$no_faktur_order' FROM detail_pembelian_order WHERE no_faktur_order = '$no_faktur_order' ";

		if ($db->query($insert_tbs_pembelian) === TRUE) {

		}
		else {
			echo "Error: " . $insert_tbs_pembelian . "<br>" . $db->error;
		}

	//INSERT DARI DETAIL pembelian ORDER KE TBS pembelian
	
}
else{

	$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]'");
	$data_konversi = mysqli_fetch_array($konversi);

	$jumlah_produk = $data['jumlah_barang'] / $data_konversi['konversi'];
	$harga = $data['harga'] * $data['jumlah_barang'];

	//INSERT DARI DETAIL pembelian ORDER KE TBS pembelian
		$insert_tbs_pembelian = "INSERT INTO tbs_pembelian (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, no_faktur_order) SELECT '$no_faktur', kode_barang, nama_barang, '$jumlah_produk', satuan, '$harga', subtotal, potongan, tax, '$no_faktur_order' FROM detail_pembelian_order WHERE no_faktur_order = '$no_faktur_order' ";

		if ($db->query($insert_tbs_pembelian) === TRUE) {

		}
		else {
			echo "Error: " . $insert_tbs_pembelian . "<br>" . $db->error;
		}

	//INSERT DARI DETAIL pembelian ORDER KE TBS pembelian

}


$update_status_order = $db->query("UPDATE pembelian_order SET status_order = 'Di Proses' WHERE no_faktur_order = '$no_faktur_order' ");

?>