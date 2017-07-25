<?php 
include 'db.php';
include 'sanitasi.php';

$kode_produk = stringdoang($_GET['kode_barang']);
	
$query_satuan = $db->query("SELECT sk.id_satuan, s.nama FROM satuan_konversi sk INNER JOIN satuan s ON sk.id_satuan = s.id WHERE sk.kode_produk = '$kode_produk' ");

$query_satuandasar = $db->query("SELECT s.nama, b.satuan FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.kode_barang = '$kode_produk' ");
$data_satuan_dasar = mysqli_fetch_array($query_satuandasar);


$arr = array();

$id_satuan_dasar = $data_satuan_dasar['satuan'];
$nama_satuan_dasar = $data_satuan_dasar['nama'];

while ($data_satuan = mysqli_fetch_array($query_satuan)) {

		$temp = array(
		"id" => $data_satuan['id_satuan'],
		"nama" => $data_satuan['nama']
		);

		array_push($arr, $temp);
	}

	$data = json_encode($arr);

echo '{"satuan": '.$data.', "nama_satuan_dasar": "'.$nama_satuan_dasar.'", "id_satuan_dasar": "'.$id_satuan_dasar.'"}';


 ?>