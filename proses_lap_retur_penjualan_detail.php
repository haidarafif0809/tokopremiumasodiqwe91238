<?php session_start();


include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT s.nama AS nama_satuan,drp.no_faktur_retur,drp.tanggal,drp.kode_barang,drp.nama_barang,drp.jumlah_retur,drp.satuan,drp.harga,drp.potongan,drp.subtotal FROM detail_retur_penjualan drp INNER JOIN satuan s ON drp.satuan = s.id WHERE drp.tanggal >= '$dari_tanggal' AND drp.tanggal <= '$sampai_tanggal'");





 ?>

 <style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="card card-block">

<div class="table-responsive">
					<table id="tableuser" class="table table-bordered">
					<thead>

					<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
					<th style="background-color: #4CAF50; color: white;"> Tanggal </th>					
					<th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Retur </th>
					<th style="background-color: #4CAF50; color: white;"> Satuan </th>
					<th style="background-color: #4CAF50; color: white;"> Harga </th>
					<th style="background-color: #4CAF50; color: white;"> Potongan </th>
					<th style="background-color: #4CAF50; color: white;"> Subtotal </th>

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
					<td>". $data1['kode_barang'] ."</td>
					<td>". $data1['nama_barang'] ."</td>
					<td>". $data1['jumlah_retur'] ."</td>
					<td>". $data1['nama_satuan'] ."</td>
					<td>". rp($data1['harga']) ."</td>
					<td>". rp($data1['potongan']) ."</td>
					<td>". rp($data1['subtotal']) ."</td>
					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   

					?>

					</tbody>
					</table>
</div>

<br>

       <a href='cetak_lap_retur_penjualan_detail.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success' target='blank' ><i class='fa fa-print'> </i> Cetak Retur Penjualan </a>

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>