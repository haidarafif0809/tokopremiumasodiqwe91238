<?php session_start();


include 'sanitasi.php';
include 'db.php';


$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$user = $_SESSION['nama'];
$id = angkadoang($_POST['id']);
$subtotal = angkadoang($_POST['subtotal']);


$query00 = $db->query("SELECT * FROM tbs_item_keluar WHERE id = '$id'");
$data = mysqli_fetch_array($query00);


$query = $db->prepare("UPDATE tbs_item_keluar SET jumlah = ?, subtotal = ? WHERE id = ?");


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

