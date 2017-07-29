<?php 
include 'sanitasi.php';
include 'db.php';

$kode_barang = stringdoang($_GET['kode_barang']);

$query = $db->query("SELECT COUNT(kode_barang) AS jumlah_data FROM barang LEFT JOIN satuan_konversi ON barang.id = satuan_konversi.id_produk  AND barang.kode_barang = satuan_konversi.kode_produk WHERE barang.kode_barang = '$kode_barang' OR satuan_konversi.kode_barcode = '$kode_barang' ");
$jumlah = mysqli_fetch_array($query);

if ($jumlah['jumlah_data'] > 0){

  echo "1";
}
else {

}

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db);
        
 ?>