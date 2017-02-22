<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
	 $id = $_POST['id'];
	 $no_faktur = $_POST['no_faktur'];
	 $user = $_SESSION['user_name'];
	 

 // INSERT HISTORY KAS keluar
$kas_keluar = $db->query("SELECT * FROM kas_keluar WHERE no_faktur = '$no_faktur'");
$data_kas_keluar = mysqli_fetch_array($kas_keluar);

$insert_kas_keluar = $db->query("INSERT INTO history_kas_keluar (no_faktur, keterangan, dari_akun, jumlah, tanggal, jam, user, user_hapus) VALUES ('$no_faktur','$data_kas_keluar[keterangan]','$data_kas_keluar[dari_akun]','$data_kas_keluar[jumlah]', '$data_kas_keluar[tanggal]','$data_kas_keluar[jam]','$data_kas_keluar[user]', '$user')");


// INSERT HISTORY DETAIL KAS keluar
$detail_kas_keluar = $db->query("SELECT * FROM detail_kas_keluar WHERE no_faktur = '$no_faktur'");
while($data_detail_kas_keluar = mysqli_fetch_array($detail_kas_keluar)){

	$insert_kas_keluar = $db->query("INSERT INTO history_detail_kas_keluar (no_faktur, keterangan, dari_akun, ke_akun, jumlah, tanggal, jam, user, user_hapus) VALUES ('$no_faktur', '$data_detail_kas_keluar[keterangan]', '$data_detail_kas_keluar[dari_akun]', '$data_detail_kas_keluar[ke_akun]', '$data_detail_kas_keluar[jumlah]', '$data_detail_kas_keluar[tanggal]', '$data_detail_kas_keluar[jam]', '$data_detail_kas_keluar[user]', '$user')");

} 



//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($insert_kas_keluar == TRUE)
{
	echo "sukses";
}
else
{

	}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
