<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=export_laporan_mutasi_stok.xls");

include 'db.php';
include 'sanitasi.php';

$dari_tanggal = stringdoang($_GET['dari_tanggal']); 
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$sub_nilai_akhir = 0;
$sub_nilai_masuk = 0;
$sub_nilai_keluar = 0;
$sub_nilai_awal = 0;

?>

<div class="container">
<center><h3><b>Laporan Mutasi Stok</b></h3></center>

	<table id="table_filter_stok_opname" class="table table-bordered table-sm">
    	<thead>
     
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Kode Item </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nama Item </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Satuan </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Awal </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Awal </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Masuk </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Masuk </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Keluar </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Keluar </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Akhir </th>
        <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Akhir </th>

    	</thead>
  <tbody>
<?php 

$query_cek_barang = $db->query("SELECT b.nama_barang, b.kode_barang, b.satuan, s.nama FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.berkaitan_dgn_stok != 'Jasa' ");
while($data_cek_barang = mysqli_fetch_array($query_cek_barang)){


	$pembelian = $db->query("SELECT dp.kode_barang, SUM(p.potongan) AS diskon_faktur FROM pembelian p 
	INNER JOIN detail_pembelian dp ON p.no_faktur = dp.no_faktur WHERE dp.kode_barang = '$data_cek_barang[kode_barang]'
	AND p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
	$cek_pembelian = mysqli_fetch_array($pembelian);
	$diskon = $cek_pembelian['diskon_faktur'];

	$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$data_cek_barang[kode_barang]' AND tanggal <'$dari_tanggal'");
	$cek_awal_masuk = mysqli_fetch_array($hpp_masuk);

	$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$data_cek_barang[kode_barang]' AND tanggal <'$dari_tanggal'");
	$cek_awal_keluar = mysqli_fetch_array($hpp_keluar);

	$awal = $cek_awal_masuk['jumlah_kuantitas'] - $cek_awal_keluar['jumlah_kuantitas'];
	$nilai_awal = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

	$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE kode_barang = '$data_cek_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
	$cek_hpp_masuk = mysqli_fetch_array($hpp_masuk);

	$masuk = $cek_hpp_masuk['jumlah_kuantitas'];
	$nilai_masuk = $cek_hpp_masuk['total_hpp'];
	$nilai_masuk = $nilai_masuk;

	$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE kode_barang = '$data_cek_barang[kode_barang]' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
	$cek_hpp_keluar = mysqli_fetch_array($hpp_keluar);

	$keluar = $cek_hpp_keluar['jumlah_kuantitas'];
	$nilai_keluar = $cek_hpp_keluar['total_hpp'];

	$akhir = ($awal + $masuk) - $keluar;
	$nilai_akhir = ($nilai_awal + $nilai_masuk) - $nilai_keluar;

	echo "
 	<tr>
        <td>". $data_cek_barang["kode_barang"] ."</td>
        <td>". $data_cek_barang["nama_barang"] ."</td>
        <td>". $data_cek_barang["nama"] ."</td>
        <td>". rp($awal) ."</td>
        <td>". rp($nilai_awal) ."</td>
        <td>". rp($masuk) ."</td>
        <td>". rp($nilai_masuk) ."</td>
        <td>". rp($keluar) ."</td>
        <td>". rp($nilai_keluar) ."</td>
        <td>". rp($akhir) ."</td>
        <td>". rp($nilai_akhir) ."</td>
     <tr>
     ";
}
//Akhir Data Mutasi Stok 

	//Start untuk Data Mutasi Stok
	$pembelian = $db->query("SELECT dp.kode_barang, SUM(p.potongan) AS diskon_faktur FROM pembelian p INNER JOIN detail_pembelian dp ON p.no_faktur = dp.no_faktur WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");
	$cek_pembelian = mysqli_fetch_array($pembelian);
	$diskon = $cek_pembelian['diskon_faktur'];

	$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE tanggal <'$dari_tanggal'");
	$cek_awal_masuk = mysqli_fetch_array($hpp_masuk);

	$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE tanggal <'$dari_tanggal'");
	$cek_awal_keluar = mysqli_fetch_array($hpp_keluar);

	$awal = $cek_awal_masuk['jumlah_kuantitas'] - $cek_awal_keluar['jumlah_kuantitas'];
	$nilai_awal = $cek_awal_masuk['total_hpp'] - $cek_awal_keluar['total_hpp'];

	$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_masuk WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
	$cek_hpp_masuk = mysqli_fetch_array($hpp_masuk);

	$masuk = $cek_hpp_masuk['jumlah_kuantitas'];
	$nilai_masuk = $cek_hpp_masuk['total_hpp'];
	$nilai_masuk = $nilai_masuk;

	$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah_kuantitas, SUM(total_nilai) AS total_hpp FROM hpp_keluar WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ");
	$cek_hpp_keluar = mysqli_fetch_array($hpp_keluar);

	$keluar = $cek_hpp_keluar['jumlah_kuantitas'];
	$nilai_keluar = $cek_hpp_keluar['total_hpp'];

	$akhir = ($awal + $masuk) - $keluar;
	$nilai_akhir = ($nilai_awal + $nilai_masuk) - $nilai_keluar;

	$sub_nilai_akhir = $sub_nilai_akhir + $nilai_akhir;
	$sub_nilai_awal = $sub_nilai_awal + $nilai_awal;
	$sub_nilai_masuk = $sub_nilai_masuk + $nilai_masuk;
	$sub_nilai_keluar = $sub_nilai_keluar + $nilai_keluar;

	$nama_total = 'Total Akhir';
	echo "
 	<tr>
        <td>". $nama_total ."</td>
        <td></td>
        <td></td>
        <td></td>
        <td>". rp($sub_nilai_awal) ."</td>
        <td></td>
        <td>". rp($sub_nilai_masuk) ."</td>
        <td></td>
        <td>". rp($sub_nilai_keluar) ."</td>
        <td></td>
        <td>". rp($sub_nilai_akhir) ."</td>
     <tr>
     ";

 ?>
    </tbody>
 </table>

 </div> <!--end container-->
