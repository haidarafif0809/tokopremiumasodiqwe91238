<?php 

include 'db.php';

$hpp_masuk = $db->query("SELECT jumlah_kuantitas,sisa,harga_unit FROM hpp_masuk WHERE kode_barang = '0001' ORDER BY id ASC");

$total_aset = 0;

while ($ambil_hpp_masuk = mysqli_fetch_array($hpp_masuk)){

$total_aset = $total_aset +($ambil_hpp_masuk['harga_unit'] * $ambil_hpp_masuk['sisa']);

}

echo $total_aset;

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>