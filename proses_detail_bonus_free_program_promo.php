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
    $qty = angkadoang($_POST['qty']);
$insert_produk = $db->prepare("INSERT INTO promo_free_produk (nama_program,nama_produk,qty) VALUES (?,?,?)");
  
// hubungkan "data" dengan prepared statements
$insert_produk->bind_param("iii",
$id_program,$id_produk,$qty);
       
  

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

