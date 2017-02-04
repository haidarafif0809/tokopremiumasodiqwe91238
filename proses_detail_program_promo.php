<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';

// cek koneksi
if ($db->connect_errno) {
die('Koneksi gagal: ' .$db->connect_errno.
' - '.$db->connect_error);
}

	$id_program = angkadoang($_POST['id_program']);
    $id_produk = angkadoang($_POST['id_produk']);
$insert_produk = $db->prepare("INSERT INTO produk_promo (nama_program,nama_produk) VALUES (?,?)");
  
// hubungkan "data" dengan prepared statements
$insert_produk->bind_param("ii",
$id_program,$id_produk);
       
  

    $insert_produk->execute();
 
// cek query
if (!$insert_produk) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
/*else {
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang">';
}*/
 
// tutup statements
$insert_produk->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        
?>

