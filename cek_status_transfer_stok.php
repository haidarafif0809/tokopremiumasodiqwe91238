<?php include 'session_login.php';
include 'db.php';
include 'sanitasi.php';

include 'persediaan.function.php';

$session_id = session_id();

if (isset($_GET['no_faktur'])) {

		$no_faktur = stringdoang($_GET['no_faktur']);

		$query_tbs_transfer_stok = $db->query("SELECT kode_barang,nama_barang,SUM(jumlah) AS jumlah FROM tbs_transfer_stok WHERE no_faktur = '$no_faktur' AND (session_id IS NULL OR session_id = '') GROUP BY kode_barang ");

	}
	else{
		$query_tbs_transfer_stok = $db->query("SELECT kode_barang,nama_barang,SUM(jumlah) AS jumlah FROM tbs_transfer_stok WHERE session_id = '$session_id' AND (no_faktur IS NULL OR no_faktur = '') GROUP BY kode_barang ");

	}	



$arr = array();
$status_jual = 0;
while ($data_tbs_transfer_stok = mysqli_fetch_array($query_tbs_transfer_stok)) {
	# code...


		if (isset($_GET['no_faktur'])) {

			$no_faktur = stringdoang($_GET['no_faktur']);


		$query_detail_transfer_stok = $db->query("SELECT SUM(jumlah) AS jumlah_barang FROM detail_transfer_stok WHERE no_faktur = '$no_faktur' AND kode_barang = '$data_tbs_transfer_stok[kode_barang]'");

		$data_detail_transfer_stok = mysqli_fetch_array($query_detail_transfer_stok);


		$stok = cekStokHpp($data_tbs_transfer_stok['kode_barang']) + $data_detail_transfer_stok['jumlah_barang'];

		}
		else{
		$stok = cekStokHpp($data_tbs_transfer_stok['kode_barang']);	
		}
		

		$selisih_stok = $stok  - $data_tbs_transfer_stok['jumlah'];

	


	if ($selisih_stok < 0) {
		# code...

		$temp = array(
		"kode_barang" => $data_tbs_transfer_stok['kode_barang'],
		"nama_barang" => $data_tbs_transfer_stok['nama_barang'],
		"stok" => $stok,
		"jumlah_jual" => $data_tbs_transfer_stok['jumlah']
		);

	$status_jual += 1;

		array_push($arr, $temp);
	}



	} //endwhile

	$data = json_encode($arr);

echo '{ "status": "'.$status_jual.'" ,"barang": '.$data.'}';


 ?>