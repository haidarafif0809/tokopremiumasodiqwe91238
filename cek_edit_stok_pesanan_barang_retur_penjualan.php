<?php
include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$no_faktur = stringdoang($_POST['no_faktur']);
$satuan = stringdoang($_POST['satuan']);
$no_faktur_jual = stringdoang($_POST['no_faktur_jual']);



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
    //mengambil jummlah sisa barang dari hpp_keluar
$select_hpp = $db->query("SELECT SUM(sisa_barang) AS sisa_barang FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur_jual' ");
$data = mysqli_fetch_array($select_hpp);

//mengambil data jumlah detail 
$queryyy = $db->query("SELECT dp.jumlah_retur AS jumlah_detail ,tp.jumlah_retur AS jumlah_tbs  FROM detail_retur_penjualan dp LEFT JOIN tbs_retur_penjualan tp ON dp.no_faktur_retur = tp.no_faktur_retur WHERE dp.kode_barang = '$kode_barang' AND dp.no_faktur_retur = '$no_faktur' AND dp.no_faktur_penjualan = '$no_faktur_jual' ");
     
     $data000 = mysqli_fetch_array($queryyy);
     $sisa_barang = ($data['sisa_barang'] + $data000['jumlah_detail']);



echo $a = $sisa_barang - $abc;



        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
?>