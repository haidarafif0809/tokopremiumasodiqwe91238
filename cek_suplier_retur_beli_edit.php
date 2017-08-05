<?php session_start();
include 'db.php';
include 'sanitasi.php';

$nofaktur_rb = stringdoang($_POST['nofaktur_rb']);

$query = $db->query("SELECT no_faktur_pembelian FROM tbs_retur_pembelian WHERE no_faktur_retur = '$nofaktur_rb' ORDER BY id ASC LIMIT 1");
$data = mysqli_fetch_array($query);

$cek_suplier = $db->query("SELECT COUNT(suplier) AS jumlah_data, suplier FROM pembelian WHERE no_faktur = '$data[no_faktur_pembelian]' ");
$data_suplier = mysqli_fetch_array($cek_suplier);

if ($data_suplier['jumlah_data'] == 0) {
	
	echo 0;
}else{
	echo$data_suplier['suplier'];
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>