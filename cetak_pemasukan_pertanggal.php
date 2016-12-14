<?php include 'session_login.php';

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$tanggal = stringdoang($_GET ['tanggal']);
$dari_akun = stringdoang($_GET['dari_akun']);


$total_pemasukan_dari_akun = $db->query("SELECT * FROM detail_kas_masuk WHERE tanggal = '$tanggal' AND dari_akun = '$dari_akun'");

$sum_total_pemasukan = $db->query("SELECT  SUM(jumlah) AS total_pemasukan FROM detail_kas_masuk WHERE tanggal = '$tanggal' AND dari_akun = '$dari_akun'");
$data_total_pemasukan = mysqli_fetch_array($sum_total_pemasukan);
$total_pemasukan = $data_total_pemasukan['total_pemasukan'];




 ?>

 <h2> Pemasukan Dari Akun <?php echo $dari_akun; ?> Tanggal : <?php echo tanggal($tanggal); ?> = Rp. <?php echo rp($total_pemasukan); ?></h2><br>


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



