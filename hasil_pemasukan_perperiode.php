<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
$dari_akun = stringdoang($_POST['dari_akun']);


// Pemasukan


$total_pemasukan_dari_akun = $db->query("SELECT * FROM detail_kas_masuk WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_akun = '$dari_akun'");

$sum_total_pemasukan = $db->query("SELECT  SUM(jumlah) AS total_pemasukan FROM detail_kas_masuk WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND dari_akun = '$dari_akun'");
$data_total_pemasukan = mysqli_fetch_array($sum_total_pemasukan);
$total_pemasukan = $data_total_pemasukan['total_pemasukan'];



 ?>

 <h2> Pemasukan Dari Akun <?php echo $dari_akun; ?> Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_pemasukan); ?></h2><br>

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th> Nomor Faktur </th>
			<th> Keterangan </th>
			<th> Dari Akun </th>
			<th> Jumlah </th>
			<th> Tanggal </th>
			<th> Jam </th>
			<th> User </th>	
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($total_pemasukan_dari_akun))

			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". $data1['dari_akun'] ."</td>
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
<a href='cetak_pemasukan_perperiode.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>&dari_akun=<?php echo $dari_akun; ?>' class='btn btn-success' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak  </a>
</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>

<?php include 'footer.php'; ?>