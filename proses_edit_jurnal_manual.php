<?php 

include 'sanitasi.php';
include 'db.php';


$no_faktur = stringdoang($_GET['no_faktur']);

$delete = $db->query("DELETE FROM tbs_jurnal WHERE no_faktur = '$no_faktur'");

$perintah = $db->query("SELECT j.kode_akun_jurnal,j.debit,j.kredit,d.nama_daftar_akun FROM jurnal_trans j INNER JOIN daftar_akun d ON j.kode_akun_jurnal = d.kode_daftar_akun WHERE j.no_faktur = '$no_faktur'");
while ($data = mysqli_fetch_array($perintah))
{

$perintah1 = $db->query("INSERT INTO tbs_jurnal (no_faktur, kode_akun_jurnal, nama_akun_jurnal, debit, kredit) VALUES ('$no_faktur','$data[kode_akun_jurnal]','$data[nama_daftar_akun]','$data[debit]','$data[kredit]')");


}
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=edit_jurnal_manual.php?no_faktur='.$no_faktur.'">';


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>


