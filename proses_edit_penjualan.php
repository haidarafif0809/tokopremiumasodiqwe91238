<?php 

include 'db.php';
include 'sanitasi.php';


$no_faktur = stringdoang($_GET['no_faktur']);
$kode_pelanggan = stringdoang($_GET['kode_pelanggan']);
$nama_gudang = stringdoang($_GET['nama_gudang']);
$kode_gudang = stringdoang($_GET['kode_gudang']);

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


        $tipe = $db->query("SELECT berkaitan_dgn_stok FROM barang WHERE kode_barang = '$data[kode_barang]'");
        $data_tipe = mysqli_fetch_array($tipe);
        $ber_stok = $data_tipe['berkaitan_dgn_stok'];

	        // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
        $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data, konversi FROM satuan_konversi WHERE kode_produk = '$data[kode_barang]' AND id_satuan = '$data[satuan]' ");
        $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

        // QUERY CEK BARCODE DI SATUAN KONVERSI

        if ($data_satuan_konversi['jumlah_data'] > 0 ) {
        						
        	$jumlah_barang = $data['jumlah_barang'] / $data_satuan_konversi['konversi'];

        }else{

        	$jumlah_barang = $data['jumlah_barang'];
        }


		$perintah1 = $db->query("INSERT INTO tbs_penjualan (no_faktur, kode_barang, nama_barang, jumlah_barang, satuan, harga, subtotal, potongan, tax, hpp,tipe_barang,harga_konversi) VALUES ( '$data[no_faktur]', '$data[kode_barang]', '$data[nama_barang]',
			'$jumlah_barang', '$data[satuan]', '$data[harga]', '$data[subtotal]','$data[potongan]', '$data[tax]', '$data[hpp]','$ber_stok','$data[harga_konversi]')");
		if($data_bonus_penjualan['no_faktur_penjualan'] == $no_faktur){
				//insert_tbs_bonus  dari detail_bonus
				$query_insert_tbs_bonus = $db->query("INSERT INTO tbs_bonus_penjualan (no_faktur_penjualan,kode_pelanggan,kode_produk,nama_produk,satuan,harga_disc,qty_bonus,subtotal,keterangan) VALUES ('$data_bonus_penjualan[no_faktur_penjualan]','$data_bonus_penjualan[kode_pelanggan]','$data_bonus_penjualan[kode_produk]','$data_bonus_penjualan[nama_produk]','$data_bonus_penjualan[satuan]','$data_bonus_penjualan[harga_disc]','$data_bonus_penjualan[qty_bonus]','$data_bonus_penjualan[subtotal]','$data_bonus_penjualan[keterangan]')");
				}// end if ($data_bonus_penjualan['no_faktur_penjualan'] == $no_faktur)

}//end while

 header ('location:edit_penjualan.php?no_faktur='.$no_faktur.'&kode_pelanggan='.$kode_pelanggan.'&nama_gudang='.$nama_gudang.'&kode_gudang='.$kode_gudang.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>