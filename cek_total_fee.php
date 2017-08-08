<?php session_start();


include 'sanitasi.php';
include 'db.php';

$nama_petugas = stringdoang($_POST['nama_petugas']);
$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


$query0 = $db->query("SELECT IFNULL(SUM(jumlah_fee),0) AS total_fee FROM laporan_fee_produk WHERE nama_petugas = '$nama_petugas' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek0 = mysqli_fetch_array($query0);
echo$total_fee = $cek0['total_fee'];


                  //Untuk Memutuskan Koneksi Ke Database
                  mysqli_close($db);   
?>