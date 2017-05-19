<?php session_start();

include 'db.php';
include 'sanitasi.php';
include 'persediaan.function.php';

$session_id = session_id();
$kode_parcel = stringdoang($_POST['kode_parcel']);
$total_hpp = 0;

$query_tbs_parcel = $db->query("SELECT b.kode_barang FROM tbs_parcel tp INNER JOIN barang b ON tp.id_produk = b.id WHERE tp.session_id = '$session_id' AND tp.kode_parcel = '$kode_parcel'");
while ($data_parcel = mysqli_fetch_array($query_tbs_parcel)) {
	$nilai_hpp = cekNilaihpp($data_parcel['kode_barang']);
	$total_hpp = $total_hpp + $nilai_hpp;
}

?>