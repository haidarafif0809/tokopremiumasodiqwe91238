<?php 
include 'db.php';
include 'sanitasi.php';

$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);



$select = $db->query("SELECT SUM(dp.potongan) AS total_potongan,
SUM(dp.tax) AS total_tax,
SUM(dp.subtotal) AS total_subtotal,
SUM(dp.jumlah_barang) AS jml_item,
SUM(p.kredit) AS total_kredit
FROM detail_penjualan dp LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' ");
$row = mysqli_fetch_array($select);

 echo json_encode($row);
    exit;


 ?>