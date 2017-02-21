<?php session_start();
//memasukkan file db.php
include 'db.php';
include 'sanitasi.php';

	$kode_parcel = stringdoang($_POST['kode_parcel']);
	$nama_parcel = stringdoang($_POST['nama_parcel']);
	$harga_parcel_1 = angkadoang($_POST['harga_parcel_1']);
	$harga_parcel_2 = angkadoang($_POST['harga_parcel_2']);
	$harga_parcel_3 = angkadoang($_POST['harga_parcel_3']);
	$harga_parcel_4 = angkadoang($_POST['harga_parcel_4']);
	$harga_parcel_5 = angkadoang($_POST['harga_parcel_5']);
	$harga_parcel_6 = angkadoang($_POST['harga_parcel_6']);
	$harga_parcel_7 = angkadoang($_POST['harga_parcel_7']);
	$jumlah_parcel = angkadoang($_POST['jumlah_parcel']);
	$nama_petugas = $_SESSION['nama'];


		$insert_perakitan_parcel = "INSERT INTO perakitan_parcel (kode_parcel, nama_parcel, harga_parcel, harga_parcel_2, harga_parcel_3, harga_parcel_4, harga_parcel_5, harga_parcel_6, harga_parcel_7, jumlah_parcel, user_input) 
		VALUES ('$kode_parcel', '$nama_parcel', '$harga_parcel_1', '$harga_parcel_2', '$harga_parcel_3', '$harga_parcel_4', '$harga_parcel_5', '$harga_parcel_6', '$harga_parcel_7', '$jumlah_parcel', '$nama_petugas')";

			if ($db->query($insert_perakitan_parcel) === TRUE) {
			} 
			
			else {
			echo "Error: " . $insert_perakitan_parcel . "<br>" . $db->error;
			}



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>