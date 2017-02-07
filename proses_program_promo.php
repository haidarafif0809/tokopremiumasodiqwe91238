<?php 
    //memasukkan file db.php
    include 'db.php';
    include 'sanitasi.php';

// cek koneksi
if ($db->connect_errno) {
die('Koneksi gagal: ' .$db->connect_errno.
' - '.$db->connect_error);
}

	$kode_program = stringdoang($_POST['kode_program']);
    $nama_program = stringdoang($_POST['nama_program']);
    $batas_akhir = stringdoang($_POST['batas_akhir']);
    $syarat_belanja = angkadoang($_POST['syarat_belanja']);
    $jenis_bonus = stringdoang($_POST['jenis_bonus']);
 	$tanggal = date('Y-m-d');
$insert_program = $db->prepare("INSERT INTO program_promo (kode_program,nama_program,batas_akhir,syarat_belanja,jenis_bonus,tanggal) VALUES (?,?,?,?,?,?)");
  
// hubungkan "data" dengan prepared statements
$insert_program->bind_param("sssiss",
$kode_program, $nama_program, $batas_akhir, $syarat_belanja, $jenis_bonus
,$tanggal);
       
  

    $insert_program->execute();
 
// cek query
if (!$insert_program) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
/*else {
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=barang.php?kategori=semua&tipe=barang">';
}*/
 
// tutup statements
$insert_program->close();
 

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);           
        
?>

