<?php
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST

        $id = angkadoang($_POST['id']);
        $kode_program = stringdoang($_POST['kode_program']);
        $nama_program = stringdoang($_POST['nama_program']);
        $batas_akhir = stringdoang($_POST['batas_akhir']);
        $syarat_belanja = stringdoang($_POST['syarat_belanja']);
        $jenis_bonus = stringdoang($_POST['jenis_bonus']);

    // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
    $query = $db->prepare("UPDATE program_promo SET kode_program = ?, nama_program = ?, batas_akhir = ?, syarat_belanja = ?, jenis_bonus = ? WHERE id = ?");
    
    $query->bind_param("sssssi",
        $kode_program,$nama_program,$batas_akhir,$syarat_belanja,$jenis_bonus,$id);


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