<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_kartu_stok.xls");

include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_GET['id_produk']);
$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);
$bulan = stringdoang($_GET['bulan']);
$tahun = stringdoang($_GET['tahun']);
$moon = stringdoang($_GET['moon']);


$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;
 ?>


<div class="container">

<table style="color:blue;">
	<tbody>
		<tr><center><h3><b>Data Kartu Stok</b></h3></center></tr>
		<tr><td><b>Kode Barang</b></td> <td>=</td> <td><b><?php echo $kode_barang ?></b></td> </tr>
		<tr><td><b>Nama Barang</b></td> <td>=</td> <td><b><?php echo $nama_barang ?></b></td> </tr>
		<tr><td><b>Bulan</b></td> <td>=</td> <td><b><?php echo $moon ?></b></td> </tr>
		<tr><td><b>Tahun</b></td> <td>=</td> <td><b><?php echo $tahun ?></b></td> </tr>
	</tbody>
</table>
</b>
</h3>
    <table id="kartu_stok" class="table table-bordered">

        <!-- membuat nama kolom tabel -->
        <thead>

      <th style='background-color: #4CAF50; color:white'> No Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Tipe </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Masuk </th>
      <th style='background-color: #4CAF50; color:white'> Jumlah Keluar </th>
      <th style='background-color: #4CAF50; color:white'> Saldo</th>

</thead>
<tbody>
<tr style="color:red;">
<td></td>
<td style='background-color:gold;'>Saldo Awal</td>
<td></td>
<td></td>
<td></td>
<td style='background-color:gold;'><?php echo $total_saldo ?></td>
</tr>

<?php 


$select = $db->query("SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' UNION SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,
	tanggal,jenis_hpp FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun' ORDER BY tanggal ASC");

while($data = mysqli_fetch_array($select))
	{

if ($data['jenis_hpp'] == '1')
{
	$masuk = $data['jumlah_kuantitas'];
	$total_saldo = ($total_saldo + $masuk);

			echo "<tr>
			<td>". $data['no_faktur'] ."</td>
			<td>". $data['jenis_transaksi'] ."</td>
			<td>". $data['tanggal'] ."</td>
			<td>". $masuk ."</td>
		  	<td>0</td>
		  	<td>". $total_saldo ."</td>
			";
}
else
{

$keluar = $data['jumlah_kuantitas'];
$total_saldo = $total_saldo - $keluar;

			echo "<tr>
			<td>". $data['no_faktur'] ."</td>
			<td>". $data['jenis_transaksi'] ."</td>
			<td>". $data['tanggal'] ."</td>
			<td>0</td>
		  	<td>".$keluar."</td>
		  	<td>". $total_saldo ."</td>
			";
}

		echo "</tr>";


} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!--Closed Container-->



