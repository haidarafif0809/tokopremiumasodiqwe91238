<?php 
include 'db.php';
include 'sanitasi.php';
	
$query_satuan = $db->query("SELECT id, nama FROM satuan");



$arr = array();
while ($data_satuan = mysqli_fetch_array($query_satuan)) {


		$temp = array(
		"id" => $data_satuan['id'],
		"nama" => $data_satuan['nama']
		);

		array_push($arr, $temp);
	}


	$data = json_encode($arr);

echo '{"satuan": '.$data.'}';


 ?>