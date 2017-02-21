<?php session_start();

// memasukan file db.php
include 'db.php';


$session_id = session_id();
$potongan_penjualan = $_GET['potongan_penjualan'];
$potongan_persen = $_GET['potongan_persen'];



$ambil_diskon_tax = $db->query("SELECT * FROM setting_diskon_tax");
$data_diskon = mysqli_fetch_array($ambil_diskon_tax);

$query = $db->query("SELECT SUM(subtotal) AS total_penjualan FROM tbs_penjualan WHERE session_id = '$session_id'");

$data = mysqli_fetch_array($query);
$total = $data['total_penjualan'];


if ( $potongan_penjualan == "" || $potongan_penjualan == 0 ) {

		$nominal = $total / 100 * $potongan_persen;
		$data_diskon = array('nominal' => $nominal , 'persen'=>$potongan_persen);	
		echo json_encode(intval($data_diskon);
	}

else{

	$persen = $potongan_penjualan * 100 / $total;

	$data_diskon = array('nominal' => $potongan_penjualan , 'persen'=>$persen);	
	echo json_encode(intval($data_diskon));

}	

exit;

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);

  ?>


