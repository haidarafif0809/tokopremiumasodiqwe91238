<?php session_start();

include 'db.php';

$kode_barang = $_POST['kode_barang'];

$tanggal_sekarang = $_POST['tanggal_sekarang'];


$querytbs = $db->query("SELECT b.id,sum(tp.subtotal) as sub_tp,pp.nama_produk,pr.syarat_belanja FROM tbs_penjualan tp LEFT JOIN barang b ON tp.kode_barang = b.kode_barang LEFT JOIN produk_promo pp ON b.id = pp.nama_produk LEFT JOIN program_promo pr ON pp.nama_program = pr.id WHERE pr.batas_akhir >= '$tanggal_sekarang' AND pp.nama_produk = b.id AND pr.jenis_bonus = 'Free Produk' ");
$idtbs = mysqli_fetch_array($querytbs);
$produk = $idtbs['nama_produk'];
$sub = $idtbs['sub_tp'];
$syarat = $idtbs['syarat_belanja'];
if ($produk > 0 && $sub >= $syarat){

  echo 1;
}
else {
echo 0;
}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

