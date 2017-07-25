<?php session_start();
include 'db.php';
include 'sanitasi.php';

include 'persediaan.function.php';


$session_id = session_id();
	
$query_tbs_penjualan = $db->query("SELECT kode_barang,nama_barang,jumlah_barang,satuan FROM tbs_penjualan WHERE session_id = '$session_id' AND tipe_barang = 'Barang' ");

$arr = array();
$status_jual = 0;
$stok = 0;
$jumlah_barang = 0;
while ($data_tbs_penjualan = mysqli_fetch_array($query_tbs_penjualan)) {

	$stok = cekStokHpp($data_tbs_penjualan['kode_barang']);


	     // QUERY CEK BARCODE DI SATUAN KONVERSI
                                    
        $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlah_data, konversi FROM satuan_konversi WHERE kode_produk = '$data_tbs_penjualan[kode_barang]' AND id_satuan = '$data_tbs_penjualan[satuan]' ");
        $data_satuan_konversi = mysqli_fetch_array($query_satuan_konversi);     

        // QUERY CEK BARCODE DI SATUAN KONVERSI

	
        if ($data_satuan_konversi['jumlah_data'] > 0 ) {
        								
        	$jumlah_tbs_penjualan = $data_tbs_penjualan['jumlah_barang'] * $data_satuan_konversi['konversi'];

        }else{

        	$jumlah_tbs_penjualan = $data_tbs_penjualan['jumlah_barang'];
        }

        $jumlah_barang = $jumlah_tbs_penjualan + $jumlah_barang;

		$selisih_stok = $stok - $jumlah_barang;

	if ($selisih_stok < 0) {

		$temp = array(
		"kode_barang" => $data_tbs_penjualan['kode_barang'],
		"nama_barang" => $data_tbs_penjualan['nama_barang'],
		"stok" => $stok,
		"jumlah_jual" => $jumlah_barang
		);

		$status_jual += 1;

		array_push($arr, $temp);
	}else{
		$jumlah_barang = 0;
	}

} //endwhile

	$data = json_encode($arr);
echo '{ "status": "'.$status_jual.'" ,"barang": '.$data.'}';


 ?>