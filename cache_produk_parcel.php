<?php session_start();
include 'db.php';
include 'sanitasi.php';
include 'cache.class.php';


    // setup 'default' cache
    $c = new Cache();

     // store a string

    // generate a new cache file with the name 'newcache'
    

    $c->setCache('produk_parcel');

    $c->eraseAll();



$query = $db->query("SELECT * FROM perakitan_parcel ");
while ($data = $query->fetch_array()) {
 # code...
    // store an array
    $c->store($data['kode_parcel'], array(
      'kode_parcel' => $data['kode_parcel'],
      'nama_parcel' => $data['nama_parcel'],
      'harga_parcel' => $data['harga_parcel'],
      'harga_parcel_2' => $data['harga_parcel_2'],
      'harga_parcel_3' => $data['harga_parcel_3'],
      'harga_parcel_4' => $data['harga_parcel_4'],
      'harga_parcel_5' => $data['harga_parcel_5'],
      'harga_parcel_6' => $data['harga_parcel_6'],
      'harga_parcel_7' => $data['harga_parcel_7'],
      'no_faktur' => $data['no_faktur'],
      'id' => $data['id'],


    ));




}

$c->retrieveAll();
$retrieve = $c->retrieveAll();

foreach ($retrieve as $key) {

  echo $key['kode_parcel'];echo "<br>";
  echo $key['nama_parcel'];echo "<br>";
  echo $key['harga_parcel'];echo "<br>";
}
?>