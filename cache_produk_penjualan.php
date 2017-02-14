<?php session_start();
include 'db.php';
include 'sanitasi.php';
include 'cache.class.php';


    // setup 'default' cache
    $c = new Cache();

     // store a string

    // generate a new cache file with the name 'newcache'
    

    $c->setCache('produk');

    $c->eraseAll();



$query = $db->query("SELECT * FROM barang ");
while ($data = $query->fetch_array()) {
 # code...
    // store an array
    $c->store($data['kode_barang'], array(
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

$c->retrieveAll();
$retrieve = $c->retrieveAll();

foreach ($retrieve as $key) {

  echo $key['kode_barang'];echo "<br>";
  echo $key['nama_barang'];echo "<br>";
}