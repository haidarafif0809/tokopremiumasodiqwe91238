<?php 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);

$sub_nilai_akhir = 0;
$pembelian = $db->query("SELECT dp.kode_barang, SUM(p.potongan) AS diskon_faktur,SUM(jumlah_kuantitas) AS jumlah_kuantitasm, SUM(total_nilai) AS total_hppm,SUM(jumlah_kuantitas) AS jumlah_kuantitask, SUM(total_nilai) AS total_hppk FROM pembelian p INNER JOIN detail_pembelian dp ON p.no_faktur = dp.no_faktur INNER JOIN barang b ON db.kode_barang = b.kode_barang INNER JOIN hpp_masuk hm ON hm.kode_barang = b.kode_barang  WHERE dp.kode_barang = b.kode_barang AND p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
      $cek = mysqli_fetch_array($pembelian);
      $diskon = $cek['diskon_faktur'];

      $awal = $cek['jumlah_kuantitasm'] - $cek['jumlah_kuantitask'];

      $nilai_awal = $cek['total_hppm'] - $cek['total_hppk'];

      $masuk = $cek['jumlah_kuantitasm'];

      $nilai_masuk = $cek['total_hppm'];

      $keluar = $cek['jumlah_kuantitask'];
      $nilai_keluar = $cek['total_hppk'];

      $akhir = $masuk - $keluar;
      $nilai_akhir = $nilai_masuk - $nilai_keluar;
      $sub_nilai_akhir = $sub_nilai_akhir + $nilai_akhir;
      echo $hasile = $sub_nilai_akhir;

 ?>