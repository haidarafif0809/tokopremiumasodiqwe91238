<?php 
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=data_kartu_stok_perperiode.xls");

include 'db.php';
include 'sanitasi.php';

$kode_barang = stringdoang($_GET['kode_barang']);
$nama_barang = stringdoang($_GET['nama_barang']);
$dari_tanggal = stringdoang($_GET['daritgl']);
$sampai_tanggal = stringdoang($_GET['sampaitgl']);

$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND tanggal < '$dari_tanggal' ");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];

$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND tanggal < '$dari_tanggal' ");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

 ?>


<div class="container">

<table style="color:blue;">
	<tbody>
		<tr><center><h3><b>Data Kartu Stok Perperiode</b></h3></center>
			<br>
			<center><h3><b>Dari <?php echo $dari_tanggal ?> S/d <?php echo $sampai_tanggal; ?></b></h3>
		</tr>
		<tr><td><b>Kode Barang</b></td> <td>=</td> <td><b><?php echo $kode_barang ?></b></td> </tr>
		<tr><td><b>Nama Barang</b></td> <td>=</td> <td><b><?php echo $nama_barang ?></b></td> </tr>
	
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

$select = $db->query("SELECT no_faktur,jumlah_kuantitas,jenis_transaksi,tanggal,jenis_hpp,waktu, id, jam FROM hpp_masuk 
	WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' 
	UNION SELECT no_faktur, jumlah_kuantitas,jenis_transaksi, tanggal, jenis_hpp,waktu, id, jam 
	FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ORDER BY CONCAT(tanggal,' ',jam)  ");
while($data = mysqli_fetch_array($select))
	{



	echo "<tr>

	<td>".$data['no_faktur']."</td>
	<td>".$data['jenis_transaksi']."</td>
	<td>".$data['tanggal']."</td>";

if ($data['jenis_hpp'] == '1')
{
		$masuk = $data['jumlah_kuantitas'];
		$total_saldo = ($total_saldo + $masuk);

		echo"<td>".rp($masuk)."</td>
		<td>0</td>
		<td>".rp($total_saldo)."</td>";
	
}
else
{

		$keluar = $data['jumlah_kuantitas'];
		$total_saldo = $total_saldo - $keluar;

		echo"<td>0</td>
		<td>".rp($keluar)."</td>
		<td>".rp($total_saldo)."</td>";		

}

	echo"</tr>";


} // and while

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db); 
?>
        </tbody>
    </table>      

</div> <!--Closed Container-->



