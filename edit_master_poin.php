<?php include 'session_login.php';
	//memasukkan file db.php
    include 'sanitasi.php';
    include 'db.php';
    // mengirim data, menggunakan metode POST
    
    $id = angkadoang($_POST['id']);
    $kode_barang = stringdoang($_POST['kode_barang']);
    $poin_baru = angkadoang($_POST['poin_baru']);
    $waktu = date('Y-m-d H:i:sa');
    $user = $_SESSION['nama'];

    // merubah seluruh data yang ada pada tabel user, berdasarkan masing masing kolom
    $query = $db->prepare("UPDATE master_poin SET quantity_poin = ?, user_edit = ?, waktu_edit = ? WHERE id = ? AND kode_barang = ? ");
    
    $query->bind_param("issis",
        $poin_baru,$user,$waktu, $id, $kode_barang);

    $query->execute();

if (!$query) 
{
 die('Query Error : '.$db->errno.
 ' - '.$db->error);
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>