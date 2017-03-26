<?php session_start();

include 'db.php';

$tanggal_sekarang = date('yy-mm-dd');

$querytbs = $db->query("SELECT kode_barang,sum(subtotal) sub_jumlah FROM tbs_penjualan WHERE kode_barang = '$kode_barang'");
$idtbs = mysqli_num_rows($querytbs);
$total = $idtbs['sub_jumlah'];

$querybarang = $db->query("SELECT id FROM barang WHERE kode_barang = '$idtbs[kode_barang]'");
$idbar = mysqli_num_rows($querybarang);

$queryprogram = $db->query("SELECT syarat_belanja,id,tanggal FROM program_promo WHERE tanggal = tanggal AND batas_akhir <= '$tanggal_sekarang'");
$idpro = mysqli_num_rows($queryprogram);
$syarat = $idpro['syarat_belanja'];

$query = $db->query("SELECT nama_produk,nama_program FROM promo_produk WHERE nama_produk = '$idbar[id]' and nama_program = '$idpro[id]'");
$jumlah = mysqli_num_rows($query);


if ($sub_jumlah = $syarat || $sub_jumlah > $syarat) {
	if ($jumlah > 0){

  echo 1;
}
else {

}
}
        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 

 ?>

