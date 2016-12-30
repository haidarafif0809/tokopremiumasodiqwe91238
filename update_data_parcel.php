<?php session_start();
//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

	$id_edit = stringdoang($_POST['id_edit']);
	$nama_parcel = stringdoang($_POST['nama_parcel_edit']);
	$harga_parcel_1 = angkadoang($_POST['harga_parcel_edit_1']);
	$harga_parcel_2 = angkadoang($_POST['harga_parcel_edit_2']);
	$harga_parcel_3 = angkadoang($_POST['harga_parcel_edit_3']);
	$harga_parcel_4 = angkadoang($_POST['harga_parcel_edit_4']);
	$harga_parcel_5 = angkadoang($_POST['harga_parcel_edit_5']);
	$harga_parcel_6 = angkadoang($_POST['harga_parcel_edit_6']);
	$harga_parcel_7 = angkadoang($_POST['harga_parcel_edit_7']);
	$nama_petugas = $_SESSION['nama'];


		$update_perakitan_parcel = "UPDATE perakitan_parcel SET nama_parcel = '$nama_parcel', harga_parcel = '$harga_parcel_1', harga_parcel_2 = '$harga_parcel_2', harga_parcel_3 = '$harga_parcel_3', harga_parcel_4 = '$harga_parcel_4', harga_parcel_5 = '$harga_parcel_5', harga_parcel_6 = '$harga_parcel_6', harga_parcel_7 = '$harga_parcel_7', user_input = '$nama_petugas' WHERE id = '$id_edit' ";

		if ($db->query($update_perakitan_parcel) === TRUE) {
			} 
			
		else {
			echo "Error: " . $update_perakitan_parcel . "<br>" . $db->error;
			}



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>