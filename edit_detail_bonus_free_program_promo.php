<?php
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST

        $id = angkadoang($_POST['id']);
        $nama_program = angkadoang($_POST['id_program']);
        $qty = angkadoang($_POST['qty']);
        $nama_produk = angkadoang($_POST['id_produk']);
        
    // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
    $query = $db->prepare("UPDATE promo_free_produk SET nama_program = ?, qty = ?,	nama_produk = ? WHERE id = ?");
    
    $query->bind_param("iiii",
        $nama_program, $qty, $nama_produk, $id);


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