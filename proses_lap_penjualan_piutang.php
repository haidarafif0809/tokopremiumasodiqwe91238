<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT pel.nama_pelanggan,dp.tanggal,dp.no_faktur,dp.kode_pelanggan,dp.total,dp.jam,dp.user,dp.status,dp.potongan,dp.tax,dp.tunai,dp.kredit FROM penjualan dp INNER JOIN pelanggan pel ON dp.kode_pelanggan = pel.kode_pelanggan WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND dp.kredit != 0 ");




$query02 = $db->query("SELECT SUM(kredit) AS total_piutang FROM penjualan WHERE  kredit != 0 AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_piutang = $cek02['total_piutang'];

$perintah0 = $db->query("SELECT * FROM detail_penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data0 = mysqli_fetch_array($perintah0);



$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];

$query20 = $db->query("SELECT SUM(tax) AS total_tax FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek20 = mysqli_fetch_array($query20);
$total_tax = $cek20['total_tax'];

$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];


$query30 = $db->query("SELECT SUM(kredit) AS total_kredit FROM penjualan WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek30 = mysqli_fetch_array($query30);
$total_kredit = $cek30['total_kredit'];



 ?>

 <style>

tr:nth-child(even){background-color: #f2f2f2}

</style>


  <table>
  <tbody>

      <tr><td  width="70%">Total Potongan</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_potongan); ?></td></tr>
      <tr><td width="70%">Total Pajak</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_tax); ?> </td></tr>
      <tr><td  width="70%">Total Kredit</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_kredit); ?></td></tr>
      <tr><td  width="70%">Total Akhir</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_akhir); ?> </td>
      </tr>
            
  </tbody>
  </table>
  <br><br>

<div class="card card-block">

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Tunai </th>
			<th style="background-color: #4CAF50; color: white;"> Kredit </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))

			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_pelanggan'] ." ". $data1['nama_pelanggan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['tunai']) ."</td>
			<td>". rp($data1['kredit']) ."</td>
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   
		?>
		</tbody>

	</table>
</div>
<br>


       <a href='cetak_laporan_penjualan_piutang.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Penjualan Piutang</a>

</div>

       <h3> Subtotal Piutang :  Rp. <?php echo rp($total_piutang); ?></h3>



<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>