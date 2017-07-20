<?php 

include 'db.php';
include 'sanitasi.php';


$no_faktur = stringdoang($_GET['no_faktur']);
$kode_pelanggan = stringdoang($_GET['kode_pelanggan']);
$nama_gudang = stringdoang($_GET['nama_gudang']);
$kode_gudang = stringdoang($_GET['kode_gudang']);

$perintah3 = $db->query("SELECT * FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
$data1 = mysqli_num_rows($perintah3);

if ($data1 > 0){

$perintah2 = $db->query("DELETE FROM tbs_penjualan WHERE no_faktur = '$no_faktur'");
}


//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM detail_penjualan WHERE no_faktur = '$no_faktur'");
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


		$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp,tipe_barang) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]',
			'$jumlah_barang', '$data[satuan]', '$harga', '$data[subtotal]','$data[potongan]', '$data[tax]', '$data[hpp]','$ber_stok')");




}

 header ('location:edit_penjualan.php?no_faktur='.$no_faktur.'&kode_pelanggan='.$kode_pelanggan.'&nama_gudang='.$nama_gudang.'&kode_gudang='.$kode_gudang.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>