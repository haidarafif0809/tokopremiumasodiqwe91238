<?php
include 'sanitasi.php';
include 'db.php';


$kode_barang = stringdoang($_POST['kode_barang']);
$jumlah_baru = angkadoang($_POST['jumlah_baru']);
$no_faktur = stringdoang($_POST['no_faktur']);
$no_faktur_retur = stringdoang($_POST['no_faktur_retur']);
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

 $queryy = $db->query("SELECT SUM(sisa) AS total_sisa FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND no_faktur = '$no_faktur' OR no_faktur_hpp_masuk = '$no_faktur'");
 $dataaa = mysqli_fetch_array($queryy);

 $queryyy = $db->query("SELECT IFNULL(dp.jumlah_retur,0) AS jumlah_detail ,IFNULL(tp.jumlah_retur,0) AS jumlah_tbs FROM detail_retur_pembelian dp LEFT JOIN tbs_retur_pembelian tp ON dp.no_faktur_pembelian = tp.no_faktur_pembelian WHERE dp.kode_barang = '$kode_barang' AND dp.no_faktur_pembelian = '$no_faktur' AND dp.no_faktur_retur = '$no_faktur_retur' ");
 $data000 = mysqli_fetch_array($queryyy);

 $stok = ($dataaa['total_sisa'] + $data000['jumlah_detail']);


 echo $a = $stok - $abc;


        //Untuk Memutuskan Koneksi Ke Database

        mysqli_close($db); 
        
?>