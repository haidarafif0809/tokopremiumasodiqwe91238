<?php 

include 'db.php';

$otoritas = $_POST['otoritas'];
$akses = $_POST['akses'];
$pilihan = $_POST['pilihan'];
$fungsi = $_POST['fungsi'];



$query = $db->query("SELECT * FROM akses WHERE otoritas = '$otoritas' AND akses = '$akses' AND fungsi = '$fungsi'");
$jumlah = mysqli_num_rows($query);

if ($pilihan == "Ya" AND $akses != "") {
	
	if ($jumlah > 0){
	
	echo "1";
	}
	
	
	else {

	}


}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);

 ?>

