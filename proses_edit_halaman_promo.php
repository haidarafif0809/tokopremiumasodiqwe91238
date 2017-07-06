<?php
	// memasukan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengrim data dengan menggunakan metode POST
    $id = angkadoang($_POST['id']);



       $query =$db->prepare("UPDATE halaman_promo SET nama_promo = ?, keterangan_promo = ? WHERE id = ?");

       $query->bind_param("ssi",
        $nama_promo, $keterangan_promo, $id);

           
         
           $nama_promo = stringdoang($_POST['nama_promo']);
           $keterangan_promo = $_POST['keterangan_promo'];
           $id = angkadoang($_POST['id']);

        $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}
else 
{
    echo '<META HTTP-EQUIV="Refresh" Content="0; URL=setting_halaman_promo.php">';
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
    
    ?>