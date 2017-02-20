<?php session_start();


include 'sanitasi.php';
include 'db.php';


$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$user = $_SESSION['nama'];
$id = angkadoang($_POST['id']);
$subtotal = angkadoang($_POST['subtotal']);

$query = $db->prepare("UPDATE tbs_item_masuk SET jumlah = ?, subtotal = ? WHERE id = ?");


$query->bind_param("iii",
    $jumlah_baru, $subtotal, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {

    }



//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>

