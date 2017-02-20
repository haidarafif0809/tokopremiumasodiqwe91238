<?php
include 'sanitasi.php';
include 'db.php';






$query1 = $db->prepare("UPDATE kas SET jumlah = jumlah - ? WHERE nama = ?");

$query1->bind_param("is",
	$jumlah, $ke_akun);

$jumlah = angkadoang($_POST['jumlah']);
$ke_akun = stringdoang($_POST['ke_akun']);

$query1->execute();


$query2 = $db->prepare("UPDATE kas SET jumlah = jumlah + ? WHERE nama = ?");

$query2->bind_param("is",
	$jumlah_baru, $ke_akun);

$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$ke_akun = stringdoang($_POST['ke_akun']);


$query2->execute();


$query = $db->prepare("UPDATE kas_masuk SET keterangan = ?, jumlah = ? WHERE id = ?");

$query->bind_param("sis",
	$keterangan, $jumlah_baru, $id);

$id = stringdoang($_POST['id']);
$keterangan = stringdoang($_POST['keterangan']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);

$query->execute();

$query00 = $db->prepare("UPDATE detail_kas_masuk SET jumlah = ? WHERE id = ?");
$query00->bind_param("is",
    $jumlah_baru, $id);

$jumlah_baru = angkadoang($_POST['jumlah_baru']);

$query00->execute();



    if (!$query1) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo "sukses";
    }

    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
?>