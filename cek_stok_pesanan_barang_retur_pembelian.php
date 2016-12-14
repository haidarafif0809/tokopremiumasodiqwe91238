<?php
include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$no_faktur = stringdoang($_POST['no_faktur']);
$satuan = stringdoang($_POST['satuan']);

  $konversi = $db->query("SELECT konversi FROM satuan_konversi WHERE kode_produk = '$kode_barang' AND id_satuan = '$satuan' ");
    $num_rows = mysqli_num_rows($konversi);
    $data_konversi = mysqli_fetch_array($konversi); 

    if ($num_rows > 0) {
    	$abc = $jumlah_baru * $data_konversi['konversi'];
    }
    else
    {
    	$abc = $jumlah_baru;
    }


$select_hpp = $db->query("SELECT SUM(sisa) AS sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' OR no_faktur_hpp_masuk = '$no_faktur' ");
$data = mysqli_fetch_array($select_hpp);

echo $a = $data['sisa'] - $abc;

        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
?>