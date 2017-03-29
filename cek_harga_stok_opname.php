<?php 
include 'db.php';
include 'sanitasi.php';

include 'persediaan.function.php';

$kode_barang = stringdoang($_GET['kode_barang']);


	         $pilih_hpp = $db->query("SELECT harga_unit FROM hpp_masuk WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
	         $ambil_hpp = mysqli_fetch_array($pilih_hpp);
        
	        $select2 = $db->query("SELECT harga FROM detail_pembelian WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
	        $num_rows = mysqli_num_rows($select2);
	        $fetc_array = mysqli_fetch_array($select2);
	        
	        $select3 = $db->query("SELECT harga_beli FROM barang WHERE kode_barang = '$kode_barang' ORDER BY id DESC LIMIT 1");
	        $ambil_barang = mysqli_fetch_array($select3);

	         $jumlah_hpp_minus = $ambil_hpp['harga_unit'];
             // HARGA DARI DETAIL PEMBELIAN ATAU BARANG
	        

	      	if ($num_rows == 0) {
	              // jika tidak ada pembelian maka yang diambil dari barang
	        $jumlah_hpp_plus = $ambil_barang['harga_beli'];
	        
	        } 
	        
	        else {
	         // jika ada pembelian maka yang diambil dari pembelian
	        $jumlah_hpp_plus = $fetc_array['harga'];
	        
        	}
        	$stok = cekStokHpp($kode_barang);


        	$arrayName = array(
        	'jumlah_hpp_minus' => $jumlah_hpp_minus,
        	'jumlah_hpp_plus' => $jumlah_hpp_plus,
        	'stok' => $stok

        	);

	echo json_encode($arrayName);

 ?>