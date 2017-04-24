<?php 
include 'db.php';

$kill = $db->query("show open tables WHERE in_use > 0");
$data = $kill -> fetch_array();
echo print_r($data);

if (isset($_GET['id'])) {

$id = $_GET['id'];

	$bunuh = $db->query("kill $id");
	
}

 ?>