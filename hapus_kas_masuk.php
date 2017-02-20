<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
	 $id = $_POST['id'];
	 $no_faktur = $_POST['no_faktur'];
	 $user = $_SESSION['user_name'];

 // INSERT HISTORY KAS MASUK
$kas_masuk = $db->query("SELECT * FROM kas_masuk WHERE no_faktur = '$no_faktur'");
$data_kas_masuk = mysqli_fetch_array($kas_masuk);

$insert_kas_masuk = $db->query("INSERT INTO history_kas_masuk (no_faktur, keterangan, ke_akun, jumlah, tanggal, jam, user, user_hapus) VALUES ('$no_faktur','$data_kas_masuk[keterangan]','$data_kas_masuk[ke_akun]','$data_kas_masuk[jumlah]', '$data_kas_masuk[tanggal]','$data_kas_masuk[jam]','$data_kas_masuk[user]', '$user')");


// INSERT HISTORY DETAIL KAS MASUK
$detail_kas_masuk = $db->query("SELECT * FROM detail_kas_masuk WHERE no_faktur = '$no_faktur'");
while($data_detail_kas_masuk = mysqli_fetch_array($detail_kas_masuk)){

	$insert_kas_masuk = $db->query("INSERT INTO history_detail_kas_masuk (no_faktur, keterangan, dari_akun, jumlah, tanggal, jam, user, user_hapus) VALUES ('$no_faktur', '$data_detail_kas_masuk[keterangan]', '$data_detail_kas_masuk[dari_akun]', '$data_detail_kas_masuk[jumlah]', '$data_detail_kas_masuk[tanggal]', '$data_detail_kas_masuk[jam]', '$data_detail_kas_masuk[user]', '$user')");

} 



//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($insert_kas_masuk == TRUE)
{

echo "sukses";
}
else
{
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
