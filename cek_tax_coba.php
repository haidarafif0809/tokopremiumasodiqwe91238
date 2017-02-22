<?php 
	
	$total = $_POST['total'];
	$potongan = $_POST['potongan'];
	$tax = $_POST['tax'];
	
	echo $hasil = $total - $potongan + $tax;
	

	?>