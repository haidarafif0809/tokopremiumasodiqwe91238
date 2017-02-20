<?php
include 'sanitasi.php';
include 'db.php';

$no_faktur = $_GET['no_faktur'];
$kode_parcel = $_GET['kode_parcel'];
$nama_parcel = $_GET['nama_parcel'];

$perintah3 = $db->query("SELECT * FROM tbs_parcel WHERE no_faktur = '$no_faktur' AND kode_parcel = '$kode_parcel' ");
$data_row = mysqli_num_rows($perintah3);
	if ($data_row > 0){
		$perintah2 = $db->query("DELETE FROM tbs_parcel WHERE no_faktur = '$no_faktur' AND kode_parcel = '$kode_parcel'");
	}


$perintah = $db->query("SELECT * FROM detail_perakitan_parcel WHERE no_faktur = '$no_faktur' AND kode_parcel = '$kode_parcel'");
while ($data = mysqli_fetch_array($perintah)){

	$perintah1 = $db->query("INSERT INTO tbs_parcel (no_faktur, kode_parcel, id_produk, jumlah_produk) VALUES ( '$data[no_faktur]', '$data[kode_parcel]', '$data[id_produk]', '$data[jumlah_produk]')");
}

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=edit_detail_perakitan_parcel.php?no_faktur='.$no_faktur.'&kode_parcel='.$kode_parcel.'&nama_parcel='.$nama_parcel.'">';
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 
?>