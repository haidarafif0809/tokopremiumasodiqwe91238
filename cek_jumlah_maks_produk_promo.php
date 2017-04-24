<?php session_start();


include 'db.php';
include 'sanitasi.php';
$session_id = session_id();

$tanggal_sekarang = date('Y-m-d');
$kode_produk = stringdoang($_GET['kode_barang']);

//cek  barang yang akan diedit di tbs_bonus saat ini, yang di ambil id barang nya
$query_tbs_bonus_penjualan = $db->query("SELECT b.id as id_barang FROM tbs_bonus_penjualan tb INNER JOIN barang b ON tb.kode_produk = b.kode_barang WHERE tb.session_id = '$session_id' AND tb.kode_produk = '$kode_produk' AND tb.keterangan = 'Disc Produk'");
$jumlah_data_tbs_bonus_penjualan = mysqli_num_rows($query_tbs_bonus_penjualan);
$data_tbs_bonus_penjualan = mysqli_fetch_array($query_tbs_bonus_penjualan);
$id = $data_tbs_bonus_penjualan['id_barang'];

//mengambil / cek qty maks nya (disc produk)
$query_promo_disc_produk = $db->query("SELECT  pp.qty_max FROM promo_disc_produk pp INNER JOIN program_promo pr ON pp.nama_program = pr.id WHERE pp.nama_produk = '$id' AND pr.batas_akhir >= '$tanggal_sekarang' AND pr.jenis_bonus = 'Disc Produk'");
$data_promo_disc_produk = mysqli_fetch_array($query_promo_disc_produk);



if ($jumlah_data_tbs_bonus_penjualan > 0){

  echo json_encode($data_promo_disc_produk);
}

else {
echo 0;
}



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
  ?>


