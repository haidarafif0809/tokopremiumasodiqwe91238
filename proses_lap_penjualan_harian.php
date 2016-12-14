<?php session_start();


include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT tanggal FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' GROUP BY tanggal");



 ?>


<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="card card-block">

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Transaksi </th>
					<th style="background-color: #4CAF50; color: white;"> Total Transaksi </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar Tunai </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Bayar Kredit </th>

					
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data = mysqli_fetch_array($perintah))
					{
					//menampilkan data
						$perintah1 = $db->query("SELECT * FROM penjualan WHERE tanggal = '$data[tanggal]'");
						$data1 = mysqli_num_rows($perintah1);

						$perintah2 = $db->query("SELECT SUM(total) AS t_total FROM penjualan WHERE tanggal = '$data[tanggal]'");
						$data2 = mysqli_fetch_array($perintah2);
						$t_total = $data2['t_total'];

						$perintah21 = $db->query("SELECT SUM(nilai_kredit) AS t_kredit FROM penjualan WHERE tanggal = '$data[tanggal]'");
						$data21 = mysqli_fetch_array($perintah21);
						$t_kredit = $data21['t_kredit'];

						$t_bayar = $t_total - $t_kredit;

					echo "<tr>
					<td>". $data['tanggal'] ."</td>
					<td>". $data1."</td>
					<td>". rp($t_total) ."</td>
					<td>". rp($t_bayar) ."</td>
					<td>". rp($t_kredit) ."</td>


					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>
</div>

<br>

       <a href='cetak_lap_penjualan_harian.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success'><i class='fa fa-print'> </i> Cetak Penjualan </a>

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>

<?php include 'footer.php'; ?>