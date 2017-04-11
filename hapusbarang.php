<?php 
// memasukan file db.php
include 'db.php';
include 'sanitasi.php';
include 'cache.class.php';

// mengirim data $id dengan menggunakan metode GET
$id = angkadoang($_POST['id']);

$kode_barang = stringdoang($_POST['kode_barang']);

    // membuat objek cache
      $cache = new Cache();

    // setting default cache 
      $cache->setCache('produk');

    // hapus cache
      $cache->erase($kode_barang);

// menghapus seluruh data yang ada pada tabel barang berdasrkan id
$query = $db->query("DELETE FROM barang WHERE id = '$id'");


$query_barang = $db->query("SELECT * FROM barang ");
while ($data = $query_barang->fetch_array()) {
 # code...
    // store an array
    $cache->store($data['kode_barang'], array(
      'kode_barang' => $data['kode_barang'],
      'nama_barang' => $data['nama_barang'],
      'harga_beli' => $data['harga_beli'],
      'harga_jual' => $data['harga_jual'],
      'harga_jual2' => $data['harga_jual2'],
      'harga_jual3' => $data['harga_jual3'],
      'harga_jual4' => $data['harga_jual4'],
      'harga_jual5' => $data['harga_jual5'],
      'harga_jual6' => $data['harga_jual6'],
      'harga_jual7' => $data['harga_jual7'],
      'kategori' => $data['kategori'],
      'suplier' => $data['suplier'],
      'limit_stok' => $data['limit_stok'],
      'over_stok' => $data['over_stok'],
      'berkaitan_dgn_stok' => $data['berkaitan_dgn_stok'],
      'tipe_barang' => $data['tipe_barang'],
      'status' => $data['status'],
      'satuan' => $data['satuan'],
      'id' => $data['id'],


    ));

}

      $cache->retrieve($kode_barang);


      // logika => jika $query benar maka akan menuju file barang.php , jika salah maka failed
if ($query == TRUE)
{
echo "sukses";
}
else
{
	
}
//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>
