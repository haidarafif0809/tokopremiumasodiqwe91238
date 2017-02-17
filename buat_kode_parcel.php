<?php
include 'db.php';
include 'sanitasi.php';

$q_kode_barang = $db->query("SELECT kode_parcel FROM perakitan_parcel ORDER BY id DESC LIMIT 1");
$v_kode_barang = mysqli_fetch_array($q_kode_barang);
$row_kode_barang = mysqli_num_rows($q_kode_barang);
if ($row_kode_barang = "" || $row_kode_barang = 0) {  
  echo $kode_parcel = "PP1";
}
else{
  $kode_barang_terakhir = $v_kode_barang['kode_parcel'];
  $angka_barang_terakhir = angkadoang($kode_barang_terakhir);
  $kode_produk_sekarang = 1 + $angka_barang_terakhir;
  echo $kode_parcel = "PP".$kode_produk_sekarang."";
}
              
?>