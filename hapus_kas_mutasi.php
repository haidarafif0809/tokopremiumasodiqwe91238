<?php session_start();

//memasukkan file db.php
include 'db.php';

//mengirimkan $id menggunakan metode GET
$id = $_POST['id'];
$no_faktur = $_POST['no_faktur'];
$user = $_SESSION['user_name'];

 // INSERT HISTORY KAS MUTASI
$kas_mutasi = $db->query("SELECT * FROM kas_mutasi WHERE no_faktur = '$no_faktur'");
$data_kas_mutasi = mysqli_fetch_array($kas_mutasi);

$insert_kas_mutasi = "INSERT INTO history_kas_mutasi (no_faktur, keterangan, dari_akun, ke_akun, jumlah, tanggal, jam, user, user_hapus) VALUES ('$no_faktur','$data_kas_mutasi[keterangan]','$data_kas_mutasi[dari_akun]', '$data_kas_mutasi[ke_akun]', '$data_kas_mutasi[jumlah]', '$data_kas_mutasi[tanggal]','$data_kas_mutasi[jam]','$data_kas_mutasi[user]', '$user')";

if ($db->query($insert_kas_mutasi) === TRUE) {
    
} else {
    echo "Error: " . $insert_kas_mutasi . "<br>" . $db->error;
}

//jika $query benar maka akan menuju file kas.php , jika salah maka failed
if ($insert_kas_mutasi == TRUE)
{
	echo "sukses";
}
else
{

}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
