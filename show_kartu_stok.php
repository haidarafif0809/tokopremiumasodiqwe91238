<?php 
include 'db.php';
include 'sanitasi.php';

$id = stringdoang($_POST['id_produk']);
$kode_barang = stringdoang($_POST['kode_barang']);
$bulan = stringdoang($_POST['bulan']);
$tahun = stringdoang($_POST['tahun']);

if ($bulan == '1')
{
	$moon = 'Januari';
}
else if ($bulan == '2')
{
	$moon = 'Febuari';
}
else if ($bulan == '3')
{
	$moon = 'Maret';
}
else if ($bulan == '4')
{
	$moon = 'April';
}
else if ($bulan == '5')
{
	$moon = 'Mei';
}
else if ($bulan == '6')
{
	$moon = 'Juni';
}
else if ($bulan == '7')
{
	$moon = 'Juli';
}
else if ($bulan == '8')
{
	$moon = 'Agustus';
}
else if ($bulan == '9')
{
	$moon = 'September';
}
else if ($bulan == '10')
{
	$moon = 'Oktober';
}
else if ($bulan == '11')
{
	$moon = 'November';
}
else if ($bulan == '12')
{
	$moon = 'Desember';
}

// awal Select untuk hitung Saldo Awal
$hpp_masuk = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_masuk WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out_masuk = mysqli_fetch_array($hpp_masuk);
$jumlah_masuk = $out_masuk['jumlah'];


$hpp_keluar = $db->query("SELECT SUM(jumlah_kuantitas) AS jumlah FROM hpp_keluar WHERE kode_barang = '$kode_barang' AND MONTH(tanggal) < '$bulan' AND YEAR(tanggal) = '$tahun'");
$out_keluar = mysqli_fetch_array($hpp_keluar);
$jumlah_keluar = $out_keluar['jumlah'];

$total_saldo = $jumlah_masuk - $jumlah_keluar;

$select_nama_barang = $db->query("SELECT nama_barang FROM barang WHERE kode_barang = '$kode_barang'");
$take_nama = mysqli_fetch_array($select_nama_barang);
$nama_barang = $take_nama['nama_barang'];

// akhir hitungan saldo awal
 ?>

<div class="container">

	<div class="row">
		<div class="col-sm3">
<table style="color:blue;" >
	<tbody>
			
	
		<tr><td><b>Kode Barang</b></td> <td>=</td> <td><b><?php echo $kode_barang ?></b></td> </tr>
		<tr><td><b>Nama Barang</b></td> <td>=</td> <td><b><?php echo $nama_barang ?></b></td> </tr>
		<tr><td><b>Bulan</b></td> <td>=</td> <td><b><?php echo $moon ?></b></td> </tr>
		<tr><td><b>Tahun</b></td> <td>=</td> <td><b><?php echo $tahun ?></b></td> </tr>
		
	</tbody>
</table>
</div>
	</div>

</b>
</h3>
<br>
  <div class="card card-block">
  		<center><h3><b>Data Kartu Stok</b></h3></center>

<div class="table-responsive">
    <table id="table_kartu_stoknya" class="table table-sm">

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

</div> <!-- penutup table responsive -->
</div>
<br>
<a href='export_kartu_stok.php?moon=<?php echo $moon; ?>&id_produk=<?php echo $id; ?>&kode_barang=<?php echo $kode_barang; ?>&nama_barang=<?php echo $nama_barang; ?>&bulan=<?php echo $bulan; ?>&tahun=<?php echo $tahun; ?>' type='submit' class='btn btn-default btn-lg'>Download Excel</a>

</div> <!--Closed Container-->

<script>
// untuk memunculkan data tabel 
$(document).ready(function() {
        $('#table_kartu_stoknya').DataTable({"ordering":false});
    });

</script>
