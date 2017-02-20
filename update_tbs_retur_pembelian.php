<?php
include 'sanitasi.php';
include 'db.php';

$id = stringdoang($_POST['id']);
$jumlah_retur = angkadoang($_POST['jumlah_retur']);
$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);



$query5 = $db->query("SELECT dp.no_faktur,hm.sisa FROM detail_pembelian dp INNER JOIN hpp_masuk hm ON dp.no_faktur = hm.no_faktur WHERE dp.kode_barang = '$kode_barang'");
$cek5 = mysqli_fetch_array($query5);

$j_retur = $cek5['sisa'];
$a = $j_retur  + $jumlah_retur;


if ($a < $jumlah_baru){

  echo '<div class="alert alert-danger">
            <strong>PERHATIAN!</strong> Jumlah Retur Melebihi Sisa Barang.
        </div>';

}

else{


$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_retur = angkadoang($_POST['jumlah_retur']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$harga = angkadoang($_POST['harga']);
$potongan = angkadoang($_POST['potongan']);
$tax = angkadoang($_POST['tax']);

$x = $jumlah_retur * $harga;
$sub_lama = $x - $potongan;

$subtotal = $harga * $jumlah_baru - $potongan;
$tax_tbs = $tax / $sub_lama * 100;
$jumlah_tax = $tax_tbs * $subtotal / 100;



$query3 = $db->prepare("UPDATE detail_pembelian SET sisa = sisa + ? WHERE kode_barang = ?");

$query3->bind_param("is",
    $jumlah_retur,$kode_barang);


$query3->execute();




$query2 = $db->prepare("UPDATE detail_pembelian SET sisa = sisa - ? WHERE kode_barang = ?");

$query2->bind_param("is",
    $jumlah_baru,$kode_barang);

$query2->execute();



$query = $db->prepare("UPDATE tbs_retur_pembelian SET jumlah_retur = ?, subtotal = ?, tax = ? WHERE id = ?");

$query->bind_param("iiis",
    $jumlah_baru, $subtotal, $jumlah_tax, $id);

$harga = angkadoang($_POST['harga']);

$id = stringdoang($_POST['id']);

$query->execute();

        if (!$query) 
    {
    die('Query Error : '.$db->errno.
    ' - '.$db->error);
    }
    else 
    {
    echo '<div class="alert alert-info">
            <strong>SUKSES!</strong> Retur Berhasil.
        </div>';
    }

}




    //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   




?>