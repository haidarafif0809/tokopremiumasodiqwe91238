<?php include 'session_login.php';
    include 'sanitasi.php';
    include 'db.php';

    $kode_barang = stringdoang($_POST['kode_barang']);
    $nama_barang = stringdoang($_POST['nama_barang']);
    $poin = angkadoang($_POST['poin']);
    $satuan = angkadoang($_POST['satuan']);
    $user = $_SESSION['nama'];

    $perintah = $db->prepare("INSERT INTO master_poin (kode_barang, nama_barang, satuan, quantity_poin,user)
			VALUES (?,?,?,?,?)");

    $perintah->bind_param("ssiis",
        $kode_barang,$nama_barang,$satuan,$poin,$user);

    $perintah->execute();

// cek query
if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>