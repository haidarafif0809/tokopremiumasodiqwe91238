<?php 
include 'db.php';
include 'sanitasi.php';

$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$dari_tanggal = stringdoang($_GET['dari_tanggal']);



$select = $db->query("SELECT SUM(p.kredit) AS total_piutang,
SUM(p.potongan) AS total_potongan,
SUM(p.tax) AS total_tax,
SUM(p.total) AS total_akhir,
SUM(p.kredit) AS total_kredit
FROM detail_penjualan dp LEFT JOIN penjualan p ON dp.no_faktur = p.no_faktur WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND p.kredit != 0 ");
$row = mysqli_fetch_array($select);

 echo json_encode($row);
    exit;


 ?>