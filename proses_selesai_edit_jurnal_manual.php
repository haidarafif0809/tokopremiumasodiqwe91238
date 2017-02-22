<?php session_start();

//memasukkan file db.php
include 'sanitasi.php';
include 'db.php';



$jam_sekarang = date('H:i:sa');
$jenis = stringdoang($_POST['jenis']);
$tanggal = stringdoang($_POST['tanggal']);
$no_faktur = stringdoang($_POST['no_faktur']);
$user =  $_SESSION['user_name'];
$session_jurnal_manual = stringdoang($_POST['session_id']);

$delete = $db->query("DELETE FROM jurnal_trans WHERE no_faktur = '$no_faktur'");

$query60 = $db->query("SELECT * FROM tbs_jurnal");
while($data0 = mysqli_fetch_array($query60))
{

if ($data0['session_id'] == $session_jurnal_manual) {

$insert_no_faktur_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat,user_edit) VALUES ('".no_jurnal()."','$tanggal $jam_sekarang','Jurnal Manual - $data0[keterangan]','$data0[kode_akun_jurnal]','$data0[debit]','$data0[kredit]','$jenis','$no_faktur','1','$user','$user')");


}
}


     $query3 = $db->query("DELETE FROM tbs_jurnal");

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   


    ?>