<?php 
	include 'db.php';
	include 'sanitasi.php';
			

	$kode_barang = stringdoang($_POST['kode_barang']);
	$id_barang = angkadoang($_POST['id_barang']);
	$jenis_edit = stringdoang($_POST['jenis_edit']);

	if ($jenis_edit == 'jumlah') {

	$jumlah = angkadoang($_POST['jumlah']);
	
	$query = $db->query("SELECT COUNT(*) AS jumlah FROM setting_diskon_jumlah WHERE kode_barang = '$kode_barang' AND id_barang = '$id_barang' AND syarat_jumlah = '$jumlah' ");
	$data = mysqli_fetch_array($query);

	}else{

	$potongan = angkadoang($_POST['potongan']);

	$query = $db->query("SELECT COUNT(*) AS jumlah FROM setting_diskon_jumlah WHERE kode_barang = '$kode_barang' AND id_barang = '$id_barang' AND potongan = '$potongan' ");
	$data = mysqli_fetch_array($query);

	}

	echo$data['jumlah'];

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>