<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$select_nofaktur = $db->query("SELECT no_faktur FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal' GROUP BY no_faktur ORDER BY waktu_jurnal DESC");


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

<h3> Periode : <?php echo tanggal($dari_tanggal); ?> - <?php echo tanggal($sampai_tanggal); ?> </h3>
<br>

 <table id="tableuser" class="table table-hover">
            <thead>
			<th style="font-size: 20px"> No Akun </th>
			<th style="font-size: 20px"> Nama Akun </th>
			<th style="font-size: 20px"> Debet </th>
			<th style="font-size: 20px"> Kredit </th>
			<th style="font-size: 20px"> Keterangan </th>


			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($cek = mysqli_fetch_array($select_nofaktur))

			{

$query15 = $db->query("SELECT SUM(debit) AS debit FROM jurnal_trans WHERE no_faktur = '$cek[no_faktur]'");
$cek15 = mysqli_fetch_array($query15);
$debit = $cek15['debit'];

$query105 = $db->query("SELECT SUM(kredit) AS kredit FROM jurnal_trans WHERE no_faktur = '$cek[no_faktur]'");
$cek105 = mysqli_fetch_array($query105);
$kredit = $cek105['kredit'];






				$select_jurnal = $db->query("SELECT j.id,j.nomor_jurnal, j.waktu_jurnal, j.keterangan_jurnal, j.kode_akun_jurnal, j.debit, j.kredit, j.jenis_transaksi, j.no_faktur, j.approved, j.user_buat, j.user_edit, d.nama_daftar_akun FROM jurnal_trans j INNER JOIN daftar_akun d ON j.kode_akun_jurnal = d.kode_daftar_akun WHERE j.no_faktur = '$cek[no_faktur]' ORDER BY j.id");

				$select = $db->query("SELECT id FROM jurnal_trans WHERE no_faktur = '$cek[no_faktur]' ORDER BY id DESC LIMIT 1");
				$data0 = mysqli_fetch_array($select);


				$select_no_faktur = $db->query("SELECT id FROM jurnal_trans WHERE no_faktur = '$cek[no_faktur]' ORDER BY id ASC LIMIT 1");
				$data00 = mysqli_fetch_array($select_no_faktur);


				while ($data = mysqli_fetch_array($select_jurnal))
				{

			if ($data['debit'] == 0 AND $data['kredit'] == 0) {


					}
			else{
								if ($data['id'] == $data00['id']){
					
					
					echo "<tr>
					<td><br><b> Tanggal : ". tanggal($data['waktu_jurnal']) ." </b>
					<br>
					". $data['kode_akun_jurnal']."</td>
					<td><br><b> No. Transaksi : ". $data['no_faktur'] ." </b>
					<br>
					".$data['nama_daftar_akun']."</td>
					
					<td><br><b> Ref : ". $data['jenis_transaksi'] ." / ". $data['no_faktur'] ." </b>
					<br>
					". rp($data['debit']) ."</td>
					
					<td><br><br>". rp($data['kredit']) ."</td>
					<td><br><br>". $data['keterangan_jurnal'] ."</td>
					</tr>";
					

				
				
				}

				else{

					
						echo "<tr>
					<td>
					<br>
					". $data['kode_akun_jurnal']."</td>
					<td>
					<br>
					".$data['nama_daftar_akun']."</td>
					
					<td>
					<br>
					". rp($data['debit']) ."</td>
					
					<td><br>". rp($data['kredit']) ."</td>
					<td><br>". $data['keterangan_jurnal'] ."</td>
					</tr>";

				}
			}		

				
			if ($data['id'] == $data0['id']){
				if ($debit == 0 AND $kredit == 0) {
				
				}
				
				else{
				
				echo "<tr style='color:blue'>
				<td><b>Subtotal  ". $data['no_faktur'] ."</b></td>
				<td></td>
				<td><b>". rp($debit) ."</b></td>
				<td><b>". rp($kredit) ."</b></td>
				<td></td>
				
				</tr>";	
				}

			}		


			
				}	


			}


			$sum_t_debit = $db->query("SELECT SUM(debit) AS t_debit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal'");
			$cek_t_debit = mysqli_fetch_array($sum_t_debit);
			$t_debit = $cek_t_debit['t_debit'];
			
			
			$sum_t_kredit = $db->query("SELECT SUM(kredit) AS t_kredit FROM jurnal_trans WHERE DATE(waktu_jurnal) >= '$dari_tanggal' AND DATE(waktu_jurnal) <= '$sampai_tanggal'");
			$cek_t_kredit = mysqli_fetch_array($sum_t_kredit);
			$t_kredit = $cek_t_kredit['t_kredit'];

		

			echo "<tr style='background-color: red ; color:white'>
			<td><b>Total :</b></td>
			<td></td>
			<td><b>". rp($t_debit) ."</b></td>
			<td><b>". rp($t_kredit) ."</b></td>
			<td></td>

			</tr>";	


			mysqli_close($db);
		?>
		</tbody>

	</table>
	<br><br>

       <a href='cetak_laporan_jurnal.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>'
       class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Jurnal Transaksi </a>

</div>     

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable({'ordering':false});


});
  
</script>
