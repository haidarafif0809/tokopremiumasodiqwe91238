<?php session_start();

include 'sanitasi.php';
include 'db.php';

$kode_barang = stringdoang($_POST['kode_barang']);
// pengubahan data dari form penjualan ketika ada pengeditan (mengubah koma menjadi titik agar diterima di MYSQL )
$jumlah_baru = stringdoang($_POST['jumlah_baru']);
 $jumlah_baru = str_replace(',','.',$jumlah_baru);
   if ($jumlah_baru == '') 
 {
   $jumlah_baru = 0;
 }

$jumlah_lama = stringdoang($_POST['jumlah_lama']);
 $jumlah_lama = str_replace(',','.',$jumlah_lama);
  if ($jumlah_lama == '') 
 {
   $jumlah_lama = 0;
 }

$potongan = stringdoang($_POST['potongan']);
 $potongan = str_replace(',','.',$potongan);
   if ($potongan == '') 
 {
   $potongan = 0;
 }

$harga = stringdoang($_POST['harga']);
 $harga = str_replace(',','.',$harga);
  if ($harga == '') 
 {
   $harga = 0;
 }

$jumlah_tax = stringdoang($_POST['jumlah_tax']);
 $jumlah_tax = str_replace(',','.',$jumlah_tax);
   if ($jumlah_tax == '') 
 {
   $jumlah_tax = 0;
 }

$subtotal = stringdoang($_POST['subtotal']);
 $subtotal = str_replace(',','.',$subtotal);
   if ($subtotal == '') 
 {
   $subtotal = 0;
 }

$hasil_sub = $subtotal + $jumlah_tax;
 $hasil_sub = str_replace(',','.',$hasil_sub);
   if ($hasil_sub == '') 
 {
   $hasil_sub = 0;
 }
// pengubahan data dari form penjualan ketika ada pengeditan (mengubah koma menjadi titik agar diterima di MYSQL )

$user = $_SESSION['nama'];
$id = stringdoang($_POST['id']);


        $query00 = $db->query("SELECT kode_barang,no_faktur FROM tbs_penjualan WHERE id = '$id'");
        $data = mysqli_fetch_array($query00);
        $kode = $data['kode_barang'];
        $nomor = $data['no_faktur'];


    $query = $db->prepare("UPDATE tbs_penjualan SET jumlah_barang = ?, subtotal = ?, tax = ? WHERE id = ?");
    $query->bind_param("sssi",$jumlah_baru, $hasil_sub, $jumlah_tax, $id);
    $query->execute();
    if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else
    {

    }

    
    $query9 = $db->query("SELECT jumlah_prosentase,jumlah_uang FROM fee_produk WHERE nama_petugas = '$user' AND kode_produk = '$kode'");
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
