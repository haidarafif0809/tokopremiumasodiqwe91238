<?php session_start();
 
//memasukkan file db.php
include 'sanitasi.php';
include 'db.php';

$no_faktur = stringdoang($_POST['no_faktur']);
$kode_parcel = stringdoang($_POST['kode_parcel']);
$nama_parcel = stringdoang($_POST['nama_parcel']);
$tanggal = stringdoang($_POST['tanggal']);
$harga_parcel_1 = angkadoang($_POST['harga_parcel_1']);
$harga_parcel_2 = angkadoang($_POST['harga_parcel_2']);
$harga_parcel_3 = angkadoang($_POST['harga_parcel_3']);
$harga_parcel_4 = angkadoang($_POST['harga_parcel_4']);
$harga_parcel_5 = angkadoang($_POST['harga_parcel_5']);
$harga_parcel_6 = angkadoang($_POST['harga_parcel_6']);
$harga_parcel_7 = angkadoang($_POST['harga_parcel_7']);
$jumlah_parcel = angkadoang($_POST['jumlah_parcel']);
$nama_petugas = $_SESSION['nama'];
$jam_sekarang = date('H:i:s');

$update_perakitan_parcel = $db->prepare("UPDATE perakitan_parcel SET nama_parcel = ?, harga_parcel = ?, harga_parcel_2 = ?, harga_parcel_3 = ?, harga_parcel_4 = ?, harga_parcel_5 = ?, harga_parcel_6 = ?, harga_parcel_7 = ?, jumlah_parcel = ?, user_edit = ?, tanggal = ?, jam = ? WHERE no_faktur = ?");
$update_perakitan_parcel->bind_param("siiiiiiiissss",
$nama_parcel, $harga_parcel_1, $harga_parcel_2, $harga_parcel_3, $harga_parcel_4, $harga_parcel_5, $harga_parcel_6, $harga_parcel_7, $jumlah_parcel, $nama_petugas, $tanggal, $jam_sekarang, $no_faktur);


        
$update_perakitan_parcel->execute();

if (!$update_perakitan_parcel) {
die('Query Error : '.$db->errno.
' - '.$db->error);
}
else {

}



$hapus_detail = $db->query("DELETE FROM detail_perakitan_parcel WHERE no_faktur = '$no_faktur' AND kode_parcel = '$kode_parcel'");

$query12 = $db->query("SELECT * FROM tbs_parcel WHERE no_faktur = '$no_faktur' AND kode_parcel = '$kode_parcel' ");
while ($data = mysqli_fetch_array($query12)) {
	
	$subtotal = $data['subtotal_produk'] * $jumlah_parcel;
	
	$query2 = "INSERT INTO detail_perakitan_parcel (no_faktur,kode_parcel,id_produk,jumlah_produk,tanggal,jam, harga_produk, subtotal_produk) VALUES ('$no_faktur','$data[kode_parcel]', '$data[id_produk]', '$data[jumlah_produk]', '$tanggal', '$jam_sekarang', '$data[harga_produk]', '$subtotal')";

	if ($db->query($query2) === TRUE) {
	} 

	else {
	echo "Error: " . $query2 . "<br>" . $db->error;
	}

}

$hapus_tbs = $db->query("DELETE FROM tbs_parcel WHERE no_faktur = '$no_faktur' AND kode_parcel = '$kode_parcel' ");


?>