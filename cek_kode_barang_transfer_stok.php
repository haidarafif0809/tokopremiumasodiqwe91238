<?php session_start();
include 'db.php';
include 'sanitasi.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$session_id = session_id();

	if (isset($_POST['no_faktur'])) {
		
		$no_faktur = stringdoang($_POST['no_faktur']);


		$query = $db->query("SELECT kode_barang FROM tbs_transfer_stok WHERE kode_barang_tujuan = '$kode_barang' 
		AND (session_id  = '' OR session_id IS NULL) AND no_faktur = '$no_faktur' ");

	}
	else{

		$query = $db->query("SELECT kode_barang FROM tbs_transfer_stok WHERE kode_barang_tujuan = '$kode_barang' 
		AND (no_faktur  = '' OR no_faktur IS NULL) AND session_id = '$session_id' ");

	}

		$jumlah = mysqli_num_rows($query);



		  echo $jumlah;

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

