<?php 

include 'db.php';
include 'sanitasi.php';

header("Content-type:application/json");


$kode_barang =  stringdoang($_GET['kode_barang']);
$level_harga =  stringdoang($_GET['level_harga']);
$jumlah_barang =  stringdoang($_GET['jumlah_barang']);
$satuan_konversi =  stringdoang($_GET['satuan_konversi']);
$id_produk =  stringdoang($_GET['id_produk']);

$query = $db->query("SELECT harga_jual,harga_jual2,harga_jual3,harga_jual4,harga_jual5,harga_jual6,harga_jual7 FROM barang WHERE kode_barang = '$kode_barang'");
$data_harga = mysqli_fetch_array($query);

if ($level_harga == 'harga_1') {
	 $harga = $data_harga['harga_jual'];
}
elseif ($level_harga == 'harga_2') {
	 $harga = $data_harga['harga_jual2'];
}
elseif ($level_harga == 'harga_3') {
	 $harga = $data_harga['harga_jual3'];
}
elseif ($level_harga == 'harga_4') {
	 $harga = $data_harga['harga_jual4'];
}
elseif ($level_harga == 'harga_5') {
	 $harga = $data_harga['harga_jual5'];
}
elseif ($level_harga == 'harga_6') {
	 $harga = $data_harga['harga_jual6'];
}
elseif ($level_harga == 'harga_7') {
	 $harga = $data_harga['harga_jual7'];
}


 $query_satuan_konversi = $db->query("SELECT COUNT(*) AS jumlahdata,IFNULL(harga_jual_konversi,0) AS harga_pokok, konversi * $harga AS harga_konversi FROM satuan_konversi WHERE id_satuan = '$satuan_konversi' AND id_produk = '$id_produk'");
 $data = mysqli_fetch_array($query_satuan_konversi);

 if ($data['jumlahdata'] == 0) {
 			$harga_konversi = 0;
 }else{

			if ($data['harga_pokok'] == 0) {
			$harga_konversi = $data['harga_konversi'];
			}else{
			$harga_konversi = $data['harga_pokok'];
			}

 }



echo '{"harga_level": "'.$harga.'", "harga_konversi": "'.$harga_konversi.'"}';


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
 ?>

