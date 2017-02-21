<?php 

include 'db.php';
include 'cache.class.php';

// membuat objek cache
	$cache = new Cache();

// setting default cache 
	$cache->setCache('mycache');

// jika data ada sudah ada di cached, maka maka gunakan yang ada di cached
if ($cache->isCached('data_produk')) {
	
	// menampilkan atau menerima data yang ada di ($cache) yang sudah dibuat, dengan memanggil *key (kata kunci)
	$tampil_cache = $cache->retrieve('data_produk');

	echo "Data Produk Dari Cached <br>";

// foreach -> pengganti while (membuat perulangan u/ menampilkan data)
	foreach ($tampil_cache as $produk) {
		
		echo $produk['kode_produk'];
		echo $produk['nama_produk'];
		echo $produk['satuan'];
		echo $produk['kategori'];
		echo $produk['status'];
		echo $produk['suplier'];
		echo $produk['harga_beli'];
		echo $produk['harga_jual'];
		echo "<br>";
	} // END OF foreach

} //END if $cached->isCached()

// jika tidak ada data dicached, tampilakan dari databse
else{

echo "Data Produk Dari Database <br>";
// membuat array kososng
	$produk = array();	

	$select = $db->query("SELECT * FROM barang");
	while ($data_produk = $select->fetch_array()) {

// menampilkan array ke dalam cache
	array_push($produk, array(

		"kode_produk" => $data_produk['kode_barang'],
		"nama_produk" => $data_produk['nama_barang'],
		"satuan" => $data_produk['satuan'],
		"kategori" => $data_produk['kategori'],
		"status" => $data_produk['status'],
		"suplier" => $data_produk['suplier'],
		"harga_beli" => $data_produk['harga_beli'],
		"harga_jual" => $data_produk['harga_jual']

		));

		echo $data_produk['kode_barang'];
		echo $data_produk['nama_barang'];
		echo $data_produk['satuan'];
		echo $data_produk['kategori'];
		echo $data_produk['status'];
		echo $data_produk['suplier'];
		echo $data_produk['harga_beli'];
		echo $data_produk['harga_jual'];
		
		echo "<br>";


	} // END while

// meamsukan array ke dalam cache
	$cache->store('data_produk', $produk);

}// END else


 ?>