<?php 
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';

$id = angkadoang($_POST['id']);

$kode_barang = stringdoang($_POST['kode']);


// menghapus seluruh data yang ada pada tabel barang berdasrkan id
$query = $db->query("DELETE FROM barang WHERE id = '$id'");

hapus_barang_cache($kode_barang);

if ($query == TRUE)
{
echo "sukses";
}
else
{

echo "gagal"; 

}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   



function hapus_barang_cache($kode_barang){

  include 'cache.class.php';

   // membuat objek cache
      $cache = new Cache();

    // setting default cache 
      $cache->setCache('produk');

  if ($cache->isCached($kode_barang)) {
    
   

    // hapus cache
      $cache->erase($kode_barang);
  }
}
?>
