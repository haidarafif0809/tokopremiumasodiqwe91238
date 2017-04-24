<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';

    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);


    $jenis_edit = stringdoang($_POST['jenis_edit']);
   $kode_barang = stringdoang($_POST['kode_barang']);



// UPDATE HARGA BELI
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
// UPDATE HARGA BELI


// UPDATE HARGA JUAL 1

else if ($jenis_edit == 'harga_jual') {

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
// UPDATE HARGA JUAL 1



// UPDATE HARGA JUAL 2
else if ($jenis_edit == 'harga_jual_2') {



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
// UPDATE HARGA JUAL 2


// UPDATE HARGA JUAL 3
else if ($jenis_edit == 'harga_jual_3') {

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
// UPDATE HARGA JUAL 3

// UPDATE HARGA JUAL 4
else if ($jenis_edit == 'harga_jual_4') {

    $input_jual_3 = angkadoang($_POST['input_jual_4']);


       $query =$db->prepare("UPDATE barang SET harga_jual4 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_4, $id);


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
// UPDATE HARGA JUAL 4


// UPDATE HARGA JUAL 5
else if ($jenis_edit == 'harga_jual_5') {

    $input_jual_3 = angkadoang($_POST['input_jual_5']);


       $query =$db->prepare("UPDATE barang SET harga_jual5 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_5, $id);


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
// UPDATE HARGA JUAL 5


// UPDATE HARGA JUAL 6
else if ($jenis_edit == 'harga_jual_6') {

    $input_jual_3 = angkadoang($_POST['input_jual_6']);


       $query =$db->prepare("UPDATE barang SET harga_jual6 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_6, $id);


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
// UPDATE HARGA JUAL 6

// UPDATE HARGA JUAL 7
else if ($jenis_edit == 'harga_jual_7') {

    $input_jual_3 = angkadoang($_POST['input_jual_7']);


       $query =$db->prepare("UPDATE barang SET harga_jual7 = ?  WHERE id = ?");

       $query->bind_param("ii",
        $input_jual_7, $id);


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
// UPDATE HARGA JUAL 7


// UPDATE KATEGORI
 else if ($jenis_select == 'kategori') {
    
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
// UPDATE KATEGORI


// UPDATE BER STOK 
 else if ($jenis_select == 'berkaitan_dgn_stok') {

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
// UPDATE BER STOK 


// UPDATE SATUAN 
   else if ($jenis_select == 'satuan') {

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
// UPDATE SATUAN  
      
      

// UPDATE STATUS  
   else if ($jenis_select == 'status') {

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
// UPDATE STATUS  
     


// UPDATE SUPLIER  
  else  if ($jenis_select == 'suplier') {

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
// UPDATE SUPLIER  


// UPDATE LIMIT STOK  
   else if ($jenis_limit == 'limit_stok') {

    $input_limit = stringdoang($_POST['input_limit']);


       $query =$db->prepare("UPDATE barang SET limit_stok = ?  WHERE id = ?");

       $query->bind_param("ii",
        $jenis_limit, $id);


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
// UPDATE LIMIT STOK  



// UPDATE OVER STOK  
   else if ($jenis_over == 'over_stok') {

    $input_over = stringdoang($_POST['input_over']);


       $query =$db->prepare("UPDATE barang SET over_stok = ?  WHERE id = ?");

       $query->bind_param("ii",
        $jenis_over, $id);


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
// UPDATE OVER STOK  


// UPDATE GUDANG  
   else if ($jenis_select == 'gudang') {


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
// UPDATE GUDANG  


  //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>