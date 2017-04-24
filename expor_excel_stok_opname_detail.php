<?php
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=detail_stok_opname.xls");
 
include 'db.php';
include 'sanitasi.php';

$dari_tanggal = $_GET['dari_tanggal'];
$sampai_tanggal= $_GET['sampai_tanggal'];



//menampilkan seluruh data yang ada pada tabel penjualan
$query = $db->query("SELECT * FROM detail_stok_opname WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' order by tanggal asc");
?>

<h3><b><center> Data Detail Stok Opname Dari Tanggal <?php echo $dari_tanggal; ?> s/d <?php echo $sampai_tanggal; ?> </center><b></h3>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<table id="tableuser" border="1">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Stok Komputer </th>
			<th style='background-color: #4CAF50; color:white'> Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Fisik </th>
			<th style='background-color: #4CAF50; color:white'> Hpp </th>
			<th style='background-color: #4CAF50; color:white'> Selisih Harga </th>

			
			
		</thead>
		
		<tbody>
		<?php
		$total = 0;
			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($query))
			{
				$total = $total + $data1['selisih_harga'];

				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['stok_sekarang'] ."</td>
			<td>". rp($data1['fisik']) ."</td>
			<td>". rp($data1['selisih_fisik']) ."</td>
			<td>". rp($data1['hpp']) ."</td>
			<td>". rp($data1['selisih_harga']) ."</td>

			</tr>";
			}

			echo "<tr>
			<td>Total</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>". rp($total) ."</td>
			
			</tr>";

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>
