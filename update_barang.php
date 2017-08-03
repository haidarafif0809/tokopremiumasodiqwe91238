<?php
  // memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    include 'cache_folder/cache.class.php';

    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);
    $jenis_edit = stringdoang($_POST['jenis_edit']);
    $kode_barang = stringdoang($_POST['kode_barang']);

    // membuat objek cache
      $cache = new Cache();

    // setting default cache 
      $cache->setCache('produk');

    // hapus cache
      $cache->eraseAll();



if ($jenis_edit == 'harga_beli') {

      $input_beli = angkadoang($_POST['input_beli']);

       $query =$db->prepare("UPDATE barang SET harga_beli = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_beli, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}


if ($jenis_edit == 'harga_jual') {

    $input_jual = angkadoang($_POST['input_jual']);

       $query =$db->prepare("UPDATE barang SET harga_jual = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}

if ($jenis_edit == 'harga_jual_2') {    
    $input_jual_2 = angkadoang($_POST['input_jual_2']);


       $query =$db->prepare("UPDATE barang SET harga_jual2 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_2, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}



if ($jenis_edit == 'harga_jual_3') {
    $input_jual_3 = angkadoang($_POST['input_jual_3']);

       $query =$db->prepare("UPDATE barang SET harga_jual3 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_3, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}




    if ($jenis_edit == 'kategori') {

    $select_kategori = stringdoang($_POST['select_kategori']);

       $query =$db->prepare("UPDATE barang SET kategori = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_kategori, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}


    if ($jenis_edit == 'berkaitan_dgn_stok') {

    $select_berstok = stringdoang($_POST['select_berstok']);

       $query =$db->prepare("UPDATE barang SET berkaitan_dgn_stok = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_berstok, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}


    if ($jenis_edit == 'satuan') {
    $select_satuan = stringdoang($_POST['select_satuan']);

       $query =$db->prepare("UPDATE barang SET satuan = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_satuan, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}
        
      

    if ($jenis_edit == 'status') {
    $select_status = stringdoang($_POST['select_status']);

       $query =$db->prepare("UPDATE barang SET status = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_status, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  
       

    if ($jenis_edit == 'suplier') {
    $select_suplier = stringdoang($_POST['select_suplier']);

       $query =$db->prepare("UPDATE barang SET suplier = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_suplier, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  



    if ($jenis_edit == 'limit_stok') {
    $input_limit = stringdoang($_POST['input_limit']);

       $query =$db->prepare("UPDATE barang SET limit_stok = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_limit, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  


    if ($jenis_edit == 'over_stok') {

    $input_over = stringdoang($_POST['input_over']);

       $query =$db->prepare("UPDATE barang SET over_stok = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_over, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  


    if ($jenis_edit == 'gudang') {
    $select_gudang = stringdoang($_POST['select_gudang']);

       $query =$db->prepare("UPDATE barang SET gudang = ?  WHERE id = ?");

       $query->bind_param("si",
        $select_gudang, $id);


        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{

}

}  


$query = $db->query("SELECT * FROM barang ");
while ($data = $query->fetch_array()) {
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

      $cache->retrieveAll();



  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>