<?php include 'session_login.php';

include 'header.php';
include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_GET ['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET ['sampai_tanggal']);
$ke_akun = stringdoang($_GET['ke_akun']);


$total_pengeluaran_keakun = $db->query("SELECT * FROM detail_kas_keluar WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND ke_akun = '$ke_akun'");

$sum_total_pengeluaran = $db->query("SELECT  SUM(jumlah) AS total_pengeluaran FROM detail_kas_keluar WHERE tanggal >= '$dari_tanggal'  AND tanggal <= '$sampai_tanggal' AND ke_akun = '$ke_akun'");
$data_total_pengeluaran = mysqli_fetch_array($sum_total_pengeluaran);
$total_pengeluaran = $data_total_pengeluaran['total_pengeluaran'];




 ?>

 <h2> Pemasukan Dari Akun <?php echo $ke_akun; ?> Tanggal : <?php echo tanggal($dari_tanggal); ?> s/d <?php echo tanggal($sampai_tanggal); ?> = Rp. <?php echo rp($total_pengeluaran); ?></h2><br>


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
			while ($data1 = mysqli_fetch_array($total_pengeluaran_keakun))

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


