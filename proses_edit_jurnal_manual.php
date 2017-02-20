<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = $_GET['no_faktur'];
$session_id = $_GET['session_id'];

$delete = $db->query("DELETE FROM tbs_jurnal WHERE session_id = '$session_id'");

$perintah = $db->query("SELECT j.kode_akun_jurnal,j.debit,j.kredit,d.nama_daftar_akun FROM jurnal_trans j INNER JOIN daftar_akun d ON j.kode_akun_jurnal = d.kode_daftar_akun WHERE j.no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah))
{

$perintah1 = $db->query("INSERT INTO tbs_jurnal (session_id, kode_akun_jurnal, nama_akun_jurnal, debit, kredit) VALUES ('$session_id','$data[kode_akun_jurnal]','$data[nama_daftar_akun]','$data[debit]','$data[kredit]')");


}

 header ('location:edit_jurnal_manual.php?no_faktur='.$no_faktur.'&session_id='.$session_id.'');


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


