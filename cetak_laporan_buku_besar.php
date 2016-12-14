<?php 

include 'sanitasi.php';
include 'header.php';
include 'db.php';


$dari_tanggal = stringdoang($_GET['dari_tanggal']);
$sampai_tanggal = stringdoang($_GET['sampai_tanggal']);
$daftar_akun = stringdoang($_GET['daftar_akun']);
$rekap = stringdoang($_GET['rekap']);


$inner_join = $db->query("SELECT j.kode_akun_jurnal, d.nama_daftar_akun FROM jurnal_trans j INNER JOIN daftar_akun d ON j.kode_akun_jurnal = d.kode_daftar_akun WHERE j.kode_akun_jurnal = '$daftar_akun'");
$ambil = mysqli_fetch_array($inner_join);
$nama_akun = $ambil['nama_daftar_akun'];

			$sum_saldo1 = $db->query("SELECT SUM(debit) AS saldo1 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
			$cek_saldo1 = mysqli_fetch_array($sum_saldo1);
			$saldo1 = $cek_saldo1['saldo1'];

			$sum_saldo2 = $db->query("SELECT SUM(kredit) AS saldo2 FROM jurnal_trans WHERE DATE(waktu_jurnal) < '$dari_tanggal' AND kode_akun_jurnal = '$daftar_akun'");
			$cek_saldo2 = mysqli_fetch_array($sum_saldo2);
			$saldo2 = $cek_saldo2['saldo2'];

			$saldo = $saldo1 - $saldo2;



$select_nofaktur = $db->query("SELECT no_faktur FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' GROUP BY no_faktur ORDER BY waktu_jurnal");

    $query1 = $db->query("SELECT * FROM perusahaan ");
    $data1 = mysqli_fetch_array($query1);
 ?>

<div class="container">
    
    <div class="row"><!--row1-->
        <div class="col-sm-">
        </div>
        <div class="col-sm-2">
                <img src='save_picture/<?php echo $data1['foto']; ?>' class='img-rounded' alt='Cinque Terre' width='130' height='110`'> 
        </div><!--penutup colsm2-->

        <div class="col-sm-8">
                 <center> <h2> <b> <?php echo $data1['nama_perusahaan']; ?> </b> </h2> 
                 <p> <?php echo $data1['alamat_perusahaan']; ?> </p> 
                 <p> No.Telp:<?php echo $data1['no_telp']; ?> </p> 

<hr>

                 <h3>Cetak Buku Besar</h3>
                 </center>
                 
        </div><!--penutup colsm5-->
        
    </div><!--penutup row1-->
</div> <!-- end of container-->


<hr>

<div class="container">
<div class="col-sm-10">
<?php if ($rekap == "direkap_perhari"): ?>

 <table>
  <tbody>
      <tr><td  width="35%">Periode</td> <td> : &nbsp;</td> <td> <?php echo tanggal($dari_tanggal); ?> - <?php echo tanggal($sampai_tanggal); ?> </td></tr>
      <tr><td  width="35%"> Kode Akun</td> <td> : &nbsp;</td> <td> <?php echo $daftar_akun; ?> </td></tr>
            

  </tbody>
</table>
</div>

<div class="col-sm-2">
	 <table>
  <tbody>
      <tr><td  width="35%">Nama Akun</td> <td> : &nbsp;</td> <td> <?php echo $nama_akun; ?> </td></tr>
  </tbody>
</table>
</div>

<br>
<br>
<br>
 <table id="tableuser" class="table table-bordered">
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
			<td></td>
			<td></td>
			<td><?php echo $saldo; ?></td>
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
 <table>
  <tbody>
      <tr><td  width="35%">Periode</td> <td> : &nbsp;</td> <td> <?php echo tanggal($dari_tanggal); ?> - <?php echo tanggal($sampai_tanggal); ?> </td></tr>
      <tr><td  width="35%"> Kode Akun</td> <td> : &nbsp;</td> <td> <?php echo $daftar_akun; ?> </td></tr>
            

  </tbody>
</table>
</div>

<div class="col-sm-2">
	 <table>
  <tbody>
      <tr><td  width="35%">Nama Akun</td> <td> : &nbsp;</td> <td> <?php echo $nama_akun; ?> </td></tr>
  </tbody>
</table>
</div>

<br>
<br>
<br>

 <table id="tableuser" class="table table-hover">
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
			<td></td>
			<td></td>
			<td><?php echo $saldo; ?></td>
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

</div>
     
	
<?php include 'footer.php'; ?>