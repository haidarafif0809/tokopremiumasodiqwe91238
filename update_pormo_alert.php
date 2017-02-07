<?php
    //memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST
    $id = angkadoang($_POST['id_promo_alert']);

    // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
    $query = $db->prepare("UPDATE promo_alert SET id_produk = ?, pesan_alert = ?, status = ? WHERE id_promo_alert = ?");
    
    $query->bind_param("issi",
        $id_produk, $pesan_alert , $status , $id);

        
        $id_produk = angkadoang($_POST['id_produk']);
        $pesan_alert = $_POST['pesan_alert'];
        $status = stringdoang($_POST['status']);
        
    $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
      echo '<META HTTP-EQUIV="Refresh" Content="0; URL=promo_alert.php">';
 
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>