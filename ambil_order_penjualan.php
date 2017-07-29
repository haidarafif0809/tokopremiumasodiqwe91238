<?php session_start();
include 'sanitasi.php';
include 'db.php';

$session_id = session_id();


$no_faktur = stringdoang($_POST['no_faktur_order']);


$perintah3 = $db->query("SELECT no_faktur_order FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur' ");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur_order = '$no_faktur'");
}

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah)){

        $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$data[kode_barang]'");
        $data_tipe = mysqli_fetch_array($tipe);
        $ber_stok = $data_tipe['berkaitan_dgn_stok'];

	        // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
        $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data, konversi FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]' ");
        $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

        // QUERY CEK BARCODE DI SATUAN KONVERSI

        if ($data_satuan_konversi['jumlah_data'] > 0 ) {
        						
        	$jumlah_barang = $data['jumlah_barang'] / $data_satuan_konversi['konversi'];
        	$harga = $data['harga'] * $data_satuan_konversi['konversi'];

        }else{

        	$jumlah_barang = $data['jumlah_barang'];
        	$harga = $data['harga'];
        }

		$perintah1 = $db->query("INSERT INTO tbs_penjualan (session_id, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax,tanggal,jam,no_faktur_order, tipe_barang) 
		VALUES ( '$session_id', '$data[kode_barang]', '$data[nama_barang]', '$jumlah_barang', '$data[satuan]', '$harga', '$data[subtotal]', '$data[potongan]', '$data[tax]', '$data[tanggal]', '$data[jam]','$no_faktur','$ber_stok')");


	}


$update_status_order = $db->query("UPDATE penjualan_order SET status_order = 'Di Proses' WHERE no_faktur_order = '$no_faktur' ");

$update_status_order = $db->query("UPDATE tbs_fee_produk SET session_id = '$session_id' WHERE no_faktur_order = '$no_faktur' ");

//Untuk Memutuskan Koneksi Ke Database
 ?>


