<?php 

include 'db.php';
include 'sanitasi.php';

$otoritas = $_POST['otoritas'];
$akses = $_POST['akses'];
$lihat = $_POST['lihat'];
$tambah = $_POST['tambah'];
$hapus = $_POST['hapus'];
$edit = $_POST['edit'];

if ($lihat == "Ya") {

	$ambil_akses = $db->query("SELECT * FROM akses WHERE akses = '$akses' AND otoritas = '$otoritas' AND fungsi = '$lihat'");
	$ambil_lihat = mysqli_num_rows($ambil_akses);
	$a = $ambil_lihat['fungsi'];

	if ($a == 0) {
		$insert = $db->query("INSERT INTO akses (otoritas,akses,fungsi) VALUES ('$otoritas', '$akses', 'Lihat' )");
	
}
}

if ($tambah == "Ya") {

	$ambil_tambah = $db->query("SELECT * FROM akses WHERE akses = '$akses' AND otoritas = '$otoritas' AND fungsi = '$tambah'");
	$ambil_akses_tambah = mysqli_num_rows($ambil_tambah);
	$b = $ambil_akses_tambah['fungsi'];

if ($b == 0) {


	$insert = $db->query("INSERT INTO akses (otoritas,akses,fungsi) VALUES ('$otoritas', '$akses', 'Tambah' )");
}

}


if ($hapus == "Ya") {

	$ambil_hapus = $db->query("SELECT * FROM akses WHERE akses = '$akses' AND otoritas = '$otoritas' AND fungsi = '$hapus'");
	$ambil_akses_hapus = mysqli_num_rows($ambil_hapus);
	$c = $ambil_lihat['fungsi'];

if ($c == 0) {


	$insert = $db->query("INSERT INTO akses (otoritas,akses,fungsi) VALUES ('$otoritas', '$akses', 'Hapus' )");

}
}



if ($edit == "Ya") {

		$ambil_edit = $db->query("SELECT * FROM akses WHERE akses = '$akses' AND otoritas = '$otoritas' AND fungsi = '$edit'");
	$ambil_akses_edit = mysqli_num_rows($ambil_edit);
	$d = $ambil_lihat['fungsi'];

if ($d == 0) {

	
	$insert = $db->query("INSERT INTO akses (otoritas,akses,fungsi) VALUES ('$otoritas', '$akses', 'Edit' )");
}
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

 ?>
