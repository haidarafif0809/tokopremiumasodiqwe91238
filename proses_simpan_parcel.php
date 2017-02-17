<?php session_start();
 
//memasukkan file db.php
include 'sanitasi.php';
include 'db.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:s');
$tahun_terakhir = substr($tahun_sekarang, 2);

$cek_jumlah_bulan = strlen($bulan_sekarang);

//jika jumlah karakter dari bulannya sama dengan 1 maka di tambah 0 di depannya
if ($cek_jumlah_bulan == 1) {
  # code...
  $data_bulan_terakhir = "0".$bulan_sekarang;
 }
 else
 {
  $data_bulan_terakhir = $bulan_sekarang;

 }
//ambil bulan dari tanggal penjualan terakhir

$bulan_terakhir = $db->query("SELECT MONTH(waktu_input) as bulan FROM perakitan_parcel ORDER BY id DESC LIMIT 1");
$v_bulan_terakhir = mysqli_fetch_array($bulan_terakhir);

//ambil nomor  dari penjualan terakhir
$no_terakhir = $db->query("SELECT no_faktur FROM perakitan_parcel ORDER BY id DESC LIMIT 1");
$v_no_terakhir = mysqli_fetch_array($no_terakhir);
$ambil_nomor = substr($v_no_terakhir['no_faktur'],0,-8);

/*jika bulan terakhir dari penjualan tidak sama dengan bulan sekarang, 
maka nomor nya kembali mulai dari 1 ,
jika tidak maka nomor terakhir ditambah dengan 1 
 */

 if ($v_bulan_terakhir['bulan'] != $bulan_sekarang) {
	echo $no_faktur = "1/PP/".$data_bulan_terakhir."/".$tahun_terakhir;
 }
 else
 {
	$nomor = 1 + $ambil_nomor ;
	echo $no_faktur = $nomor."/PP/".$data_bulan_terakhir."/".$tahun_terakhir;
 }


$insert_perakitan_parcel = $db->prepare("INSERT INTO perakitan_parcel (no_faktur, kode_parcel, nama_parcel, harga_parcel, harga_parcel_2, harga_parcel_3, harga_parcel_4, harga_parcel_5, harga_parcel_6, harga_parcel_7, jumlah_parcel, user_input, tanggal, jam) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$insert_perakitan_parcel->bind_param("sssiiiiiiiisss",
$no_faktur, $kode_parcel, $nama_parcel, $harga_parcel_1, $harga_parcel_2, $harga_parcel_3, $harga_parcel_4, $harga_parcel_5, $harga_parcel_6, $harga_parcel_7, $jumlah_parcel, $nama_petugas, $tanggal_sekarang, $jam_sekarang);

$kode_parcel = stringdoang($_POST['kode_parcel']);
$nama_parcel = stringdoang($_POST['nama_parcel']);
$harga_parcel_1 = angkadoang($_POST['harga_parcel_1']);
$harga_parcel_2 = angkadoang($_POST['harga_parcel_2']);
$harga_parcel_3 = angkadoang($_POST['harga_parcel_3']);
$harga_parcel_4 = angkadoang($_POST['harga_parcel_4']);
$harga_parcel_5 = angkadoang($_POST['harga_parcel_5']);
$harga_parcel_6 = angkadoang($_POST['harga_parcel_6']);
$harga_parcel_7 = angkadoang($_POST['harga_parcel_7']);
$jumlah_parcel = angkadoang($_POST['jumlah_parcel']);
$nama_petugas = $_SESSION['nama'];
        
$insert_perakitan_parcel->execute();

if (!$insert_perakitan_parcel) {
die('Query Error : '.$db->errno.
' - '.$db->error);
}
else {

}


$kode_parcel = stringdoang($_POST['kode_parcel']);

$query12 = $db->query("SELECT * FROM tbs_parcel WHERE kode_parcel = '$kode_parcel' ");
while ($data = mysqli_fetch_array($query12)) {
	
	$query2 = "INSERT INTO detail_perakitan_parcel (no_faktur,kode_parcel,id_produk,jumlah_produk,tanggal,jam) VALUES ('$no_faktur','$data[kode_parcel]', '$data[id_produk]', '$data[jumlah_produk]', '$tanggal_sekarang', '$jam_sekarang')";

	if ($db->query($query2) === TRUE) {
	} 

	else {
	echo "Error: " . $query2 . "<br>" . $db->error;
	}

}

$hapus_tbs = $db->query("DELETE FROM tbs_parcel WHERE kode_parcel = '$kode_parcel' ");


?>