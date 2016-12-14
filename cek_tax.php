<?php 
	
	$total = $_POST['total'];
	$potongan = $_POST['potongan'];
	$tax1 = $_POST['tax'];
	$tax = $total * $tax1 / 100;
	echo intval($hasil = $total - $potongan + $tax);
	

	?>