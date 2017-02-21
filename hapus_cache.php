<?php 
include 'cache.class.php';

// membuat objek cache
	$cache = new Cache();

// setting default cache 
	$cache->setCache('mycache');

// hapus cache
	$cache->erase('data_produk');

/*
// jika ingin menghapus semua datanya

	$cache->eraseAll();

*/

/*
header('location: file_yg_dituju.php');
*/

 ?>