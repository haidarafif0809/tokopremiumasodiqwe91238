<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
     include 'cache.class.php'; 
    // mengrim data dengan menggunakan metode POST
    $id = stringdoang($_POST['id']);



       $query =$db->prepare("UPDATE barang SET kode_barcode = ?,nama_barang = ?, harga_beli = ?, harga_jual = ?, harga_jual2 = ?, harga_jual3 = ?, satuan = ?, gudang = ?, kategori = ?, status = ?, berkaitan_dgn_stok = ?, suplier = ?, limit_stok = ?, over_stok = ?  WHERE id = ?");

       $query->bind_param("ssiiiissssssiis",
        $barcode,$nama_barang, $harga_beli, $harga_jual, $harga_jual_2, $harga_jual_3, $satuan, $gudang, $kategori, $status, $tipe, $suplier,$limit_stok, $over_stok, $id);

           
         
           $barcode = stringdoang($_POST['barcode']);
           $kode_barang = stringdoang($_POST['kode_barang']);
           $nama_barang = stringdoang($_POST['nama_barang']);
           $harga_beli = angkadoang($_POST['harga_beli']);
           $harga_jual = angkadoang($_POST['harga_jual']);
           $harga_jual_2 = angkadoang($_POST['harga_jual_2']);
           $harga_jual_3 = angkadoang($_POST['harga_jual_3']);
           $satuan = stringdoang($_POST['satuan']);
           $kategori = stringdoang($_POST['kategori']);
           $status = stringdoang($_POST['status']);
           $suplier = stringdoang($_POST['suplier']);
           $gudang = stringdoang($_POST['gudang']);
           $tipe = stringdoang($_POST['tipe']);
           $id = stringdoang($_POST['id']);
           $limit_stok = angkadoang($_POST['limit_stok']);
           $over_stok = angkadoang($_POST['over_stok']);

        $query->execute();





$query_id_barang = $db->query("SELECT id FROM barang WHERE kode_barang = '$kode_barang'");  
$data_id_barang = mysqli_fetch_array($query_id_barang);  
  
 // setup 'default' cache  
    $c = new Cache();  
    $c->setCache('produk');  
  
    $c->store($kode_barang, array(     
      'kode_barcode' => $barcode,   
      'kode_barang' => $kode_barang,
      'nama_barang' => $nama_barang,  
      'harga_beli' => $harga_beli,  
      'harga_jual' => $harga_jual,  
      'harga_jual2' => $harga_jual_2,  
      'harga_jual3' => $harga_jual_3,  
      'kategori' => $kategori,  
      'suplier' => $suplier,  
      'limit_stok' => $limit_stok,  
      'over_stok' => $over_stok,  
      'berkaitan_dgn_stok' => $golongan,  
      'tipe_barang' => $tipe,  
      'status' => $status,  
      'gudang' => $gudang, 
      'satuan' => $satuan,  
      'id' => $data_id_barang['id'] ,  
  
  
    ));  

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   header('location:barang.php?kategori=semua&tipe=barang_jasa');
}


        
        
       
  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);         




    
    ?>