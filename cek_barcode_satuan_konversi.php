<?php 

include 'db.php';
include 'sanitasi.php';

$barcode = stringdoang($_POST['barcode']);

$query = $db->query("SELECT kode_barcode FROM satuan_konversi WHERE kode_barcode = '$barcode' OR kode_produk = '$barcode' ");
$jumlah = mysqli_num_rows($query);

if ($jumlah > 0){

  echo 1;
  
}else{

	$query_barang = $db->query("SELECT kode_barcode FROM barang WHERE kode_barcode = '$barcode' OR kode_barang = '$barcode' ");
	$data_barang = mysqli_num_rows($query_barang);
	if ($data_barang > 0){

	echo 1;
	}
}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>

