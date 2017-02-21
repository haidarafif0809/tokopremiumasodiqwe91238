	<?php 


	include 'sanitasi.php';
	include 'db.php';


	$dari_tanggal = stringdoang($_POST['dari_tanggal']);
	$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);
	$daftar_akun = stringdoang($_POST['daftar_akun']);
	$rekap = stringdoang($_POST['rekap']);


				$sum_saldo1 = $db->query("SELECT SUM(debit) AS saldo1 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_saldo1 = mysqli_fetch_array($sum_saldo1);
				$saldo1 = $cek_saldo1['saldo1'];

				$sum_saldo2 = $db->query("SELECT SUM(kredit) AS saldo2 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_saldo2 = mysqli_fetch_array($sum_saldo2);
				$saldo2 = $cek_saldo2['saldo2'];

				$saldo = $saldo1 - $saldo2;



	 ?>
<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="card card-block">

	<?php if ($rekap == "direkap_perhari"): ?>
	<h3> Periode : <?php echo tanggal($dari_tanggal); ?> - <?php echo tanggal($sampai_tanggal); ?> </h3>
	<br>

	 <table id="tableuser1" class="table table-hover">
	            <thead>
				<th> No Faktur </th>
				<th> Keterangan </th>
				<th> Tanggal </th>
				<th> Debet </th>
				<th> Kredit </th>
				<th> Saldo </th>


				
			</thead>
			
			<tbody>

				<tr style="color:blue">
				<td></td>
				<td>Saldo Awal</td>
				<td></td>
				<td><?php echo rp($saldo); ?></td>
				<td></td>
				<td><?php echo rp($saldo); ?></td>
				</tr>

				<?php 

	$select = $db->query("SELECT DATE(waktu_jurnal) AS waktu_jurnal, no_faktur, keterangan_jurnal, debit, kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun' GROUP BY DATE(waktu_jurnal) ORDER BY waktu_jurnal ASC");

				//menyimpan data sementara yang ada pada $perintah
				while ($cek = mysqli_fetch_array($select))

				{

				$sum_saldo11 = $db->query("SELECT SUM(debit) AS saldo11 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_saldo11 = mysqli_fetch_array($sum_saldo11);
				$saldo11 = $cek_saldo11['saldo11'];

				$sum_saldo21 = $db->query("SELECT SUM(kredit) AS saldo21 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_saldo21 = mysqli_fetch_array($sum_saldo21);
				$saldo21 = $cek_saldo21['saldo21'];

				$saldo_xy = $saldo11 - $saldo21;



						
				$sum_t_debit = $db->query("SELECT SUM(debit) AS t_debit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_t_debit = mysqli_fetch_array($sum_t_debit);
				$t_debit = $cek_t_debit['t_debit'] + $saldo_xy; 
				
				
				$sum_t_kredit = $db->query("SELECT SUM(kredit) AS t_kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_t_kredit = mysqli_fetch_array($sum_t_kredit);
				$t_kredit = $cek_t_kredit['t_kredit'];
						
				$perintah1 = $db->query("SELECT * FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$num_rows = mysqli_num_rows($perintah1);

						$sum_t_debit = $db->query("SELECT SUM(debit) AS tt_debit FROM jurnal_trans WHERE DATE(waktu_jurnal) = '$cek[waktu_jurnal]' AND kode_akun_jurnal = '$daftar_akun' GROUP BY DATE(waktu_jurnal)");
						$cek_t_debit = mysqli_fetch_array($sum_t_debit);
						$tt_debit = $cek_t_debit['tt_debit'];

						$sum_t_kredit = $db->query("SELECT SUM(kredit) AS tt_kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) = '$cek[waktu_jurnal]' AND kode_akun_jurnal = '$daftar_akun' GROUP BY DATE(waktu_jurnal)");
						$cek_t_kredit = mysqli_fetch_array($sum_t_kredit);
						$tt_kredit = $cek_t_kredit['tt_kredit'];
								
						
						echo "<tr>
						<td><center> <b>-</b> </center></td>
						<td>Direkap Per Hari</td>
						<td>". tanggal($cek['waktu_jurnal']) ."</td>
						<td>". rp($tt_debit) ."</td>
						<td>". rp($tt_kredit) ."</td>";

						if ($tt_debit) {

						$saldo = $saldo + $tt_debit - $tt_kredit;
						echo "<td>". rp($saldo) ."</td>";
						}
						else if ($tt_kredit) {

						$saldo = $saldo + $tt_debit - $tt_kredit;

						echo "<td>". rp($saldo) ."</td>";
						}

						
						"</tr>";


				}

				echo "<tr style='color:red'>
				<td></td>
				<td></td>
				<td><b>TOTAL :</b></td>
				<td><b>". rp($t_debit) ."</b></td>
				<td><b>". rp($t_kredit) ."</b></td>
				<td><b>". rp($saldo) ."</b></td>

				</tr>";	
				mysqli_close($db);
			?>
			</tbody>

		</table>
	<?php endif ?>

	<?php if ($rekap == "tidak_direkap_perhari" || $rekap == ""): ?>
	<h3> Periode : <?php echo tanggal($dari_tanggal); ?> - <?php echo tanggal($sampai_tanggal); ?> </h3>
	<br>

	 <table id="tableuser2" class="table table-hover">
	            <thead>
				<th> No Faktur </th>
				<th> Keterangan </th>
				<th> Tanggal </th>
				<th> Debet </th>
				<th> Kredit </th>
				<th> Saldo </th>


				
			</thead>
			
			<tbody>

				<tr style="color:blue">
				
				
				
				<td>Saldo Awal</td>
				<td></td>
				<td></td>
				<td><?php echo rp($saldo); ?></td>
				<td></td>
				<td><?php echo rp($saldo); ?></td>
				</tr>

				<?php 

	$select = $db->query("SELECT waktu_jurnal, no_faktur, keterangan_jurnal, debit, kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun' ORDER BY waktu_jurnal ASC");

				//menyimpan data sementara yang ada pada $perintah
				while ($cek = mysqli_fetch_array($select))

				{

				$sum_saldo11 = $db->query("SELECT SUM(debit) AS saldo11 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_saldo11 = mysqli_fetch_array($sum_saldo11);
				$saldo11 = $cek_saldo11['saldo11'];

				$sum_saldo21 = $db->query("SELECT SUM(kredit) AS saldo21 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_saldo21 = mysqli_fetch_array($sum_saldo21);
				$saldo21 = $cek_saldo21['saldo21'];

				$saldo_xy = $saldo11 - $saldo21;
						
				$sum_t_debit = $db->query("SELECT SUM(debit) AS t_debit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_t_debit = mysqli_fetch_array($sum_t_debit);
				$t_debit = $cek_t_debit['t_debit'] + $saldo_xy; 
				



				
				$sum_t_kredit = $db->query("SELECT SUM(kredit) AS t_kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$cek_t_kredit = mysqli_fetch_array($sum_t_kredit);
				$t_kredit = $cek_t_kredit['t_kredit'];
						
				$perintah1 = $db->query("SELECT * FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
				$num_rows = mysqli_num_rows($perintah1);				
						
						echo "<tr>
						<td>". $cek['no_faktur']."</td>
						<td>". $cek['keterangan_jurnal']."</td>
						<td>". tanggal($cek['waktu_jurnal']) ."</td>
						<td>". rp($cek['debit']) ."</td>
						<td>". rp($cek['kredit']) ."</td>";

						if ($cek['debit']) {
						
						$saldo = $saldo + $cek['debit'];
						echo "<td>". rp($saldo) ."</td>";
						}
						else if ($cek['kredit']) {
						
						$saldo = $saldo - $cek['kredit'];

						echo "<td>". rp($saldo) ."</td>";
						}

						
						"</tr>";


				}

				echo "<tr style='color:red'>
				<td><b>TOTAL :</b></td>
				<td></td>
				<td><b>". rp($num_rows) ."</b></td>
				<td><b>". rp($t_debit) ."</b></td>
				<td><b>". rp($t_kredit) ."</b></td>
				<td><b>". rp($saldo) ."</b></td>

				</tr>";	
				mysqli_close($db);
			?>
			</tbody>

		</table>	
	<?php endif ?>



		<br><br>

	       <a href='cetak_laporan_buku_besar.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>&daftar_akun=<?php echo $daftar_akun; ?>&rekap=<?php echo $rekap; ?>'
	       class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Buku Besar </a>
	     
</div>

	<script>
	// untuk memunculkan data tabel 
	$(document).ready(function(){
	    $('#tableuser1').DataTable({'ordering':false});


	});
	  
	</script>

	<script>
	// untuk memunculkan data tabel 
	$(document).ready(function(){
	    $('#tableuser2').DataTable({'ordering':false});


	});
	  
	</script>
