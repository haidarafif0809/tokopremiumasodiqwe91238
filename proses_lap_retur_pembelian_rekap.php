<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT p.id,p.no_faktur_retur,p.total,p.nama_suplier,p.tunai,p.tanggal,p.jam,p.user_buat,p.potongan,p.tax,p.sisa,s.nama FROM retur_pembelian p INNER JOIN suplier s ON p.nama_suplier = s.id WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' ORDER BY p.id DESC");

$perintah1 = $db->query("SELECT * FROM detail_retur_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek = mysqli_fetch_array($perintah1);

$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM retur_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];

 ?>

  <style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="card card-block">

<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Nama Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Jumlah Retur </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>

		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{


				

				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". $cek['jumlah_retur'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['tunai']) ."</td>

			
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   

		?>
		</tbody>

	</table>
</div>
<br>


	<table>
	<tbody>
			
			
			<tr><td style="font-size: 30px" width="50%">Total</td> <td style="font-size: 30px"> :&nbsp; </td> <td style="font-size: 30px"> <?php echo rp($total_akhir); ?> </td></tr>
			
	</tbody>
	</table>
<br>

       <a href='cetak_lap_retur_pembelian_rekap.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Retur Pembelian </a>

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>