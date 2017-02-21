<?php 

include 'sanitasi.php';
include 'db.php';


$tanggal = stringdoang($_POST['tanggal']);
$ke_akun = stringdoang($_POST['ke_akun']);


// Pemasukan


$total_pengeluaran_ke_akun = $db->query("SELECT * FROM detail_kas_keluar WHERE tanggal = '$tanggal' AND ke_akun = '$ke_akun'");

$sum_total_pengeluaran = $db->query("SELECT  SUM(jumlah) AS total_pengeluaran FROM detail_kas_keluar WHERE tanggal = '$tanggal' AND ke_akun = '$ke_akun'");
$data_total_pemasukan = mysqli_fetch_array($sum_total_pengeluaran);
$total_pengeluaran = $data_total_pemasukan['total_pengeluaran'];




 ?>

 <h2> Pengeluaran Ke Akun <?php echo $ke_akun; ?> Tanggal : <?php echo tanggal($tanggal); ?> = Rp. <?php echo rp($total_pengeluaran); ?></h2><br>

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Keterangan </th>
			<th> Ke Akun </th>
			<th> Jumlah </th>
			<th> Tanggal </th>
			<th> Jam </th>
			<th> User </th>	
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_pengeluaran_ke_akun))

			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". $data1['ke_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>

			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   
		?>
		</tbody>

	</table>

</div>

<hr>



<br>
<div class="form-group">
<a href='cetak_pengeluaran_pertanggal.php?tanggal=<?php echo $tanggal; ?>&ke_akun=<?php echo $ke_akun ?>' class='btn btn-success' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak  </a>
</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>

<?php include 'footer.php'; ?>