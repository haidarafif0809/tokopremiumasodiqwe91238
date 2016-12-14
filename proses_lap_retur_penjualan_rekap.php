<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT pel.nama_pelanggan,p.no_faktur_retur,p.tanggal,p.kode_pelanggan,p.total,p.potongan,p.tax,p.tunai FROM retur_penjualan p INNER JOIN pelanggan pel ON p.kode_pelanggan = pel.kode_pelanggan WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal'");





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
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan </th>
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
				$perintah1 = $db->query("SELECT jumlah_retur FROM detail_retur_penjualan WHERE no_faktur_retur = '$data1[no_faktur_retur]'");
				$cek = mysqli_fetch_array($perintah1);
				$jumlah_retur = $cek['jumlah_retur'];
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['kode_pelanggan'] ." ".$data1['nama_pelanggan']."</td>
			<td>". $jumlah_retur ."</td>
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


       <a href='cetak_lap_retur_penjualan_rekap.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Retur Penjualan </a>

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>