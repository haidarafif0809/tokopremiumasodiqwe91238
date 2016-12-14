<?php session_start();

    include 'sanitasi.php';
    include 'db.php';

$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$waktu = date('Y-m-d H:i:sa');

    $perintah = $db->prepare("INSERT INTO kas_mutasi (no_faktur,keterangan,dari_akun,ke_akun,jumlah,tanggal,jam,user)
			VALUES (?,?,?,?,?,?,?,?) ");

    $perintah->bind_param("ssssisss",
        $no_faktur, $keterangan, $dari_akun, $ke_akun, $jumlah, $tanggal_sekarang, $jam_sekarang, $user);

    $no_faktur = stringdoang($_POST['no_faktur']);
    $keterangan = stringdoang($_POST['keterangan']);
    $dari_akun = stringdoang($_POST['dari_akun']);
    $ke_akun = stringdoang($_POST['ke_akun']);
    $tanggal = stringdoang($_POST['tanggal']);
    $jumlah = angkadoang($_POST['jumlah']);
    $user = $_SESSION['user_name'];

    $perintah->execute();



    $perintah1 = $db->prepare("UPDATE kas SET jumlah = jumlah - ? WHERE nama = ?");

    $perintah1->bind_param("is",
        $jumlah, $dari_akun);
        
    $jumlah = angkadoang($_POST['jumlah']);
    $dari_akun = stringdoang($_POST['dari_akun']);

    $perintah1->execute();



    $perintah2 = $db->prepare("UPDATE kas SET jumlah = jumlah + ? WHERE nama = ?");

    $perintah2->bind_param("is",
        $jumlah, $ke_akun);

    $jumlah = angkadoang($_POST['jumlah']);
    $ke_akun = stringdoang($_POST['ke_akun']);



    $perintah2->execute();


if (!$perintah) {
   die('Query Error : '.$db->errno.
   ' - '.$db->error);
}
else {
    header ('location:kas_mutasi.php');

}


//jurnal

    $dari_akun = stringdoang($_POST['dari_akun']);
    $ke_akun = stringdoang($_POST['ke_akun']);


    $ambil_tbs = $db->query("SELECT * FROM kas_mutasi WHERE no_faktur = '$no_faktur'");
    while ($ambil = mysqli_fetch_array($ambil_tbs))

{

                $pilih = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.dari_akun FROM daftar_akun da INNER JOIN kas_mutasi dk ON dk.dari_akun = da.kode_daftar_akun");
            $dari_akun_select = mysqli_fetch_array($pilih);

            $select = $db->query("SELECT da.nama_daftar_akun, da.kode_daftar_akun, dk.ke_akun FROM daftar_akun da INNER JOIN kas_mutasi dk ON dk.ke_akun = da.kode_daftar_akun INNER JOIN jurnal_trans jt ON jt.kode_akun_jurnal = da.kode_daftar_akun WHERE jt.kode_akun_jurnal = '$ambil[ke_akun]'");
            $ke_akun_select = mysqli_fetch_array($select);



      $insert_jurnal = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Mutasi ke $ke_akun_select[nama_daftar_akun]','$ambil[ke_akun]', '$ambil[jumlah]', '0', 'Kas Mutasi', '$no_faktur','1', '$user')");


      $insert_jurnal2 = $db->query("INSERT INTO jurnal_trans (nomor_jurnal,waktu_jurnal,keterangan_jurnal,kode_akun_jurnal,debit,kredit,jenis_transaksi,no_faktur,approved,user_buat) VALUES ('".no_jurnal()."', '$waktu', 'Transaksi Kas Mutasi dari $dari_akun_select[nama_daftar_akun]','$ambil[dari_akun]', '0', '$ambil[jumlah]', 'Kas Mutasi', '$no_faktur','1', '$user')");

}


//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

    ?>