<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = stringdoang($_POST['id']);



       $query =$db->prepare("UPDATE barang SET nama_barang = ?, harga_beli = ?, harga_jual = ?, harga_jual2 = ?, harga_jual3 = ?, satuan = ?, gudang = ?, kategori = ?, status = ?, berkaitan_dgn_stok = ?, suplier = ?, limit_stok = ?, over_stok = ?  WHERE id = ?");

       $query->bind_param("siiiissssssiis",
        $nama_barang, $harga_beli, $harga_jual, $harga_jual_2, $harga_jual_3, $satuan, $gudang, $kategori, $status, $tipe, $suplier,$limit_stok, $over_stok, $id);

           
         
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

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
   header('location:barang.php?kategori=semua&tipe=barang');
}


        
        
       
  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);         




    
    ?>