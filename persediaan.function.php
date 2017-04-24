<?php 


function cekStokHpp($kode_barang)
{

  include 'db.php';

  $query_hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang'");

  $query_hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang'");


 $data_hpp_masuk = mysqli_fetch_array($query_hpp_masuk);

 $data_hpp_keluar = mysqli_fetch_array($query_hpp_keluar);

 $stok = $data_hpp_masuk['jumlah'] - $data_hpp_keluar['jumlah'];

 return $stok;


}

 ?>