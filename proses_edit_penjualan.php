<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = $_GET['no_faktur'];
$kode_pelanggan = $_GET['kode_pelanggan'];
$nama_gudang = $_GET['nama_gudang'];
$kode_gudang = $_GET['kode_gudang'];

$query_tbs_penjualan = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$data_tbs_penjualan = mysqli_num_rows($query_tbs_penjualan);

if ($data_tbs_penjualan > 0){

$query_delete_tbs_penjualan = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$query_delete_tbs_bonus = $db->query("DELETE FROM tbs_bonus_penjualan WHERE no_faktur_penjualan = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$query_detail_penjualan = $db->query("SELECT no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, asal_satuan, harga, subtotal, potongan, tax, hpp FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
while ($data_detail_penjualan = mysqli_fetch_array($query_detail_penjualan)){

		$query_bonus_penjualan = $db->query("SELECT no_faktur_penjualan,kode_pelanggan,kode_produk,nama_produk,satuan,harga_disc,qty_bonus,subtotal,keterangan FROM bonus_penjualan WHERE no_faktur_penjualan = '$no_faktur'");
		$data_bonus_penjualan = mysqli_fetch_array($query_bonus_penjualan);

		if ($data_detail_penjualan['satuan'] == $data_detail_penjualan['asal_satuan']) {

				$query_insert_tbs_penjualan = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp) VALUES ( '$data_detail_penjualan[no_faktur]', '$data_detail_penjualan[kode_barang]', '$data_detail_penjualan[nama_barang]', '$data_detail_penjualan[jumlah_barang]', '$data_detail_penjualan[satuan]', '$data_detail_penjualan[harga]', '$data_detail_penjualan[subtotal]', '$data_detail_penjualan[potongan]', '$data_detail_penjualan[tax]', '$data_detail_penjualan[hpp]')");
			
				if($data_bonus_penjualan['no_faktur_penjualan'] == $no_faktur){
				//insert_tbs_bonus  dari detail_bonus
				$query_insert_tbs_bonus = $db->query("INSERT INTO tbs_bonus_penjualan (no_faktur_penjualan,kode_pelanggan,kode_produk,nama_produk,satuan,harga_disc,qty_bonus,subtotal,keterangan) VALUES ('$data_bonus_penjualan[no_faktur_penjualan]','$data_bonus_penjualan[kode_pelanggan]','$data_bonus_penjualan[kode_produk]','$data_bonus_penjualan[nama_produk]','$data_bonus_penjualan[satuan]','$data_bonus_penjualan[harga_disc]','$data_bonus_penjualan[qty_bonus]','$data_bonus_penjualan[subtotal]','$data_bonus_penjualan[keterangan]')");
				}// end if ($data_bonus_penjualan['no_faktur_penjualan'] == $no_faktur)
		}//end if($data_detail_penjualan['satuan'] == $data_detail_penjualan['asal_satuan'])

		else { // else dari  if ($data_detail_penjualan['satuan'] == $data_detail_penjualan['asal_satuan'])

				$konversi = $db->query("SELECT * FROM satuan_konversi WHERE kode_produk = '$data_detail_penjualan[kode_barang]' AND id_satuan = '$data_detail_penjualan[satuan]'");
				$data_konversi = mysqli_fetch_array($konversi);

				$jumlah_produk = $data_detail_penjualan['jumlah_barang'] / $data_konversi['konversi'];
				$harga = $data_detail_penjualan['harga'] * $data_detail_penjualan['jumlah_barang'];

				$query_insert_tbs_penjualan = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp) VALUES ( '$data_detail_penjualan[no_faktur]', '$data_detail_penjualan[kode_barang]', '$data_detail_penjualan[nama_barang]','$jumlah_produk', '$data_detail_penjualan[satuan]', '$harga', '$data_detail_penjualan[subtotal]','$data_detail_penjualan[potongan]', '$data_detail_penjualan[tax]', '$data_detail_penjualan[hpp]')");

				if($data_bonus_penjualan['no_faktur_penjualan'] == $no_faktur){
				//insert_tbs_bonus  dari detail_bonus
				$query_insert_tbs_bonus = $db->query("INSERT INTO tbs_bonus_penjualan (no_faktur_penjualan,kode_pelanggan,kode_produk,nama_produk,satuan,harga_disc,qty_bonus,subtotal,keterangan) VALUES ('$data_bonus_penjualan[no_faktur_penjualan]','$data_bonus_penjualan[kode_pelanggan]','$data_bonus_penjualan[kode_produk]','$data_bonus_penjualan[nama_produk]','$data_bonus_penjualan[satuan]','$data_bonus_penjualan[harga_disc]','$data_bonus_penjualan[qty_bonus]','$data_bonus_penjualan[subtotal]','$data_bonus_penjualan[keterangan]')");
				}// end if ($data_bonus_penjualan['no_faktur_penjualan'] == $no_faktur)

		}// end else dari if ($data_detail_penjualan['satuan'] == $data_detail_penjualan['asal_satuan'])

}//end while

 header ('location:edit_penjualan.php?no_faktur='.$no_faktur.'&kode_pelanggan='.$kode_pelanggan.'&nama_gudang='.$nama_gudang.'&kode_gudang='.$kode_gudang.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>