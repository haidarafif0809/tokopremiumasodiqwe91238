<?php 
	
	$total = $_POST['total'];
	$potongan = $_POST['potongan'];
	$tax1 = $_POST['tax'];
	$adm_bank1 = $_POST['adm_bank'];

	$tax = $total * $tax1 / 100;
	$adm_bank = $total * $adm_bank1 / 100;

	echo intval($hasil = $total - $potongan + $tax + $adm_bank);
	

	?>