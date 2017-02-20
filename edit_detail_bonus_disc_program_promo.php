<?php
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST

        $id = angkadoang($_POST['id']);
        $nama_program = angkadoang($_POST['id_program']);
        $qty_max = angkadoang($_POST['qty_max']);
        $harga_disc = angkadoang($_POST['harga_disc']);
        $nama_produk = angkadoang($_POST['id_produk']);
        
    // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
    $query = $db->prepare("UPDATE promo_disc_produk SET nama_program = ?, qty_max = ?, harga_disc = ?,	nama_produk= ? WHERE id = ?");
    
    $query->bind_param("iiiii",
        $nama_program, $qty_max, $harga_disc, $nama_produk, $id);


    $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
// tutup statements
$query->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>