<?php
include 'db.php';
include 'sanitasi.php';

$nomor = stringdoang($_POST['nomor']);

// THESE QUERY, DON'T BE DELETE !!
$select = $db->query("SELECT perubahan_harga FROM data_perubahan_masal WHERE nomor = '$nomor'");
$out = mysqli_fetch_array($select);
$perubahan_harga = $out['perubahan_harga'];

$select_tbs = $db->query("SELECT * FROM tbs_perubahan_harga_masal WHERE nomor = '$nomor'");
while($out_tbs = mysqli_fetch_array($select_tbs))
{

	if ($perubahan_harga == 'Level 1')
	{	

	$update_one = $db->query("UPDATE barang SET harga_jual = '$out_tbs[pembulatan]' WHERE kode_barang = '$out_tbs[kode_barang]'");

	}
	else if ($perubahan_harga == 'Level 2')
	{

	$update_two = $db->query("UPDATE barang SET harga_jual2 = '$out_tbs[pembulatan]' WHERE kode_barang = '$out_tbs[kode_barang]'");

	}
	else if ($perubahan_harga == 'Level 3')
	{

	$update_tree = $db->query("UPDATE barang SET harga_jual3 = '$out_tbs[pembulatan]' WHERE kode_barang = '$out_tbs[kode_barang]'");
	
	}
	else if ($perubahan_harga == 'Level 4')
	{

		$update_four = $db->query("UPDATE barang SET harga_jual4 = '$out_tbs[pembulatan]' WHERE kode_barang = '$out_tbs[kode_barang]'");

	}
	else if ($perubahan_harga == 'Level 5')
	{

	$update_five = $db->query("UPDATE barang SET harga_jual5 = '$out_tbs[pembulatan]' WHERE kode_barang = '$out_tbs[kode_barang]'");
	
	}
	else if ($perubahan_harga == 'Level 6')
	{

	$update_six = $db->query("UPDATE barang SET harga_jual6 = '$out_tbs[pembulatan]' WHERE kode_barang = '$out_tbs[kode_barang]'");
	
	}
	else
	{

	$update_saven = $db->query("UPDATE barang SET harga_jual7 = '$out_tbs[pembulatan]' WHERE kode_barang = '$out_tbs[kode_barang]'");
	
	}


}

$update_saven = $db->query("UPDATE data_perubahan_masal SET status = 'Selesai' WHERE nomor = '$nomor'");

$delete = $db->query("DELETE FROM tbs_perubahan_harga_masal WHERE nomor = '$nomor'");

?>