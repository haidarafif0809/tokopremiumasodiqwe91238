<?php session_start();

// memasukan file db.php
include 'db.php';


$no_faktur = $_POST['no_faktur'];
$user = $_SESSION['user_name'];

 // INSERT HISTORY JURNAL MANUAL
$jurnal_trans = $db->query("SELECT * FROM jurnal_trans WHERE no_faktur = '$no_faktur'");
while ($data_jurnal_trans = mysqli_fetch_array($jurnal_trans)){

	$insert_jurnal_trans = $db->query("INSERT INTO history_jurnal_manual (nomor_jurnal, waktu_jurnal, keterangan_jurnal, kode_akun_jurnal, debit, kredit, jenis_transaksi, no_faktur, approved, user_buat, user_edit, user_hapus) VALUES ('$data_jurnal_trans[nomor_jurnal]','$data_jurnal_trans[waktu_jurnal]','$data_jurnal_trans[keterangan_jurnal]', '$data_jurnal_trans[kode_akun_jurnal]', '$data_jurnal_trans[debit]', '$data_jurnal_trans[kredit]','$data_jurnal_trans[jenis_transaksi]','$data_jurnal_trans[no_faktur]', '$data_jurnal_trans[approved]', '$data_jurnal_trans[user_buat]', '$data_jurnal_trans[user_edit]', '$user')");

}



$hapus = $db->query("DELETE FROM nomor_faktur_jurnal WHERE no_faktur_jurnal = '$no_faktur'");


if ($insert_jurnal_trans == TRUE)
{

	echo "sukses";

}

else
{
	
	echo "gagal";
	}	
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
