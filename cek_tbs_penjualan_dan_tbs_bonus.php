<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();
 $tanggal_sekarang = $_GET['tanggal_sekarang'];
 
$tbs = $db->query("SELECT p.id,p.kode_barang,p.nama_barang FROM tbs_penjualan p LEFT JOIN tbs_bonus_penjualan pp ON p.kode_barang = pp.kode_produk WHERE p.session_id = pp.session_id AND p.tanggal = '$tanggal_sekarang'");
$tbs_pen = mysqli_num_rows($tbs);

$tb = $db->query("SELECT sum(pp.harga_disc) as harga FROM tbs_penjualan p LEFT JOIN tbs_bonus_penjualan pp ON p.kode_barang = pp.kode_produk WHERE p.session_id = pp.session_id AND p.tanggal = '$tanggal_sekarang' WHERE pp.keterangan = 'Disc Produk'");
$tbse = mysqli_num_rows($tb);

if ($tbs_pen > 0){
	$disc = $tbse['harga'];
$tbs_pen['no_faktur'] = $disc;
  echo json_encode($tbs_pen);
}
else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


