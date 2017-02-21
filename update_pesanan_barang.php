<?php session_start();


include 'sanitasi.php';
include 'db.php';



$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$jumlah_lama = angkadoang($_POST['jumlah_lama']);
$potongan = angkadoang($_POST['potongan']);
$harga = angkadoang($_POST['harga']);
$jumlah_tax = angkadoang($_POST['jumlah_tax']);
$subtotal = angkadoang($_POST['subtotal']);


$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);


$query00 = $db->query("SELECT * FROM tbs_penjualan WHERE id = '$id'");
$data = mysqli_fetch_array($query00);
$kode = $data['kode_barang'];
$nomor = $data['no_faktur'];

$query = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = ?, subtotal = ?, tax = ? WHERE id = ?");


$query->bind_param("iiii",
    $jumlah_baru, $subtotal, $jumlah_tax, $id);

$query->execute();

    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {

    }

    
    $query9 = $db->query("SELECT * FROM fee_produk WHERE nama_petugas = '$user' AND kode_produk = '$kode'");
    $cek9 = mysqli_fetch_array($query9);
    $prosentase = $cek9['jumlah_prosentase'];
    $nominal = $cek9['jumlah_uang'];

        if ($prosentase != 0)

            {
            
            $fee_prosentase_produk = $prosentase * $subtotal / 100;
            
            $query1 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_prosentase_produk' WHERE nama_petugas = '$user' AND kode_produk = '$kode' AND no_faktur = '$nomor'");
                 
            
            }

   elseif ($nominal != 0) 

            {
            
            $fee_nominal_produk = $nominal * $jumlah_baru;

            $query01 = $db->query("UPDATE tbs_fee_produk SET jumlah_fee = '$fee_nominal_produk' WHERE nama_petugas = '$user' AND kode_produk = '$kode' AND no_faktur = '$nomor'");

            }

                //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   

?>
