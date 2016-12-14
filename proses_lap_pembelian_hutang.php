<?php 

include 'sanitasi.php';
include 'db.php';


$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan

$perintah = $db->query("SELECT p.id,p.no_faktur,p.total,p.suplier,p.tanggal,p.tanggal_jt,p.jam,p.user,p.status,p.potongan,p.tax,p.sisa,p.kredit,p.nilai_kredit,s.nama,g.nama_gudang FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id INNER JOIN gudang g ON p.kode_gudang = g.kode_gudang WHERE p.tanggal >= '$dari_tanggal' AND p.tanggal <= '$sampai_tanggal' AND kredit != 0 ORDER BY p.id DESC");




$query02 = $db->query("SELECT SUM(kredit) AS total_hutang FROM pembelian WHERE  kredit != 0 AND tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek02 = mysqli_fetch_array($query02);
$total_hutang = $cek02['total_hutang'];

$perintah0 = $db->query("SELECT * FROM detail_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$data0 = mysqli_fetch_array($perintah0);



$query01 = $db->query("SELECT SUM(potongan) AS total_potongan FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek01 = mysqli_fetch_array($query01);
$total_potongan = $cek01['total_potongan'];

$query20 = $db->query("SELECT SUM(tax) AS total_tax FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek20 = mysqli_fetch_array($query20);
$total_tax = $cek20['total_tax'];

$query02 = $db->query("SELECT SUM(total) AS total_akhir FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek02 = mysqli_fetch_array($query02);
$total_akhir = $cek02['total_akhir'];


$query30 = $db->query("SELECT SUM(kredit) AS total_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek30 = mysqli_fetch_array($query30);
$total_kredit = $cek30['total_kredit'];

$query300 = $db->query("SELECT SUM(nilai_kredit) AS total_nilai_kredit FROM pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal' AND kredit != 0");
$cek300 = mysqli_fetch_array($query300);
$total_nilai_kredit = $cek300['total_nilai_kredit'];

$query15 = $db->query("SELECT SUM(dp.subtotal) AS total_subtotal FROM 
detail_pembelian dp INNER JOIN pembelian p ON dp.no_faktur = p.no_faktur WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND p.kredit != 0");
$cek15 = mysqli_fetch_array($query15);
$t_subtotal = $cek15['total_subtotal'];

$query011 = $db->query("SELECT SUM(dp.jumlah_barang) AS total_barang FROM
detail_pembelian dp INNER JOIN pembelian p ON dp.no_faktur = p.no_faktur WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal' AND p.kredit != 0");
$cek011 = mysqli_fetch_array($query011);
$t_barang = $cek011['total_barang'];

 ?>

  <style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

  <table>
  <tbody>

      <tr><td width="70%">Jumlah Item</td> <td> :&nbsp; </td> <td> <?php echo $t_barang; ?> </td></tr>
      <tr><td  width="70%">Total Subtotal</td> <td> :&nbsp; Rp.</td> <td> <?php echo rp($t_subtotal); ?> </td>
      </tr>
      <tr><td  width="70%">Total Potongan</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_potongan); ?></td></tr>
      <tr><td width="70%">Total Pajak</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_tax); ?> </td></tr>
      <tr><td  width="70%">Total Akhir</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_akhir); ?> </td>
      </tr>
      <tr><td  width="70%">Total Sisa Kredit</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_kredit); ?></td></tr>
      <tr><td  width="70%">Total Nilai Kredit</td> <td> :&nbsp; Rp. </td> <td> <?php echo rp($total_nilai_kredit); ?></td></tr>
            
  </tbody>
  </table>
  <br><br>

<div class="card card-block">

<div class="table-responsive">
 <table id="tableuser" class="table table-bordered">
            <thead>
			<th style="background-color: #4CAF50; color: white;"> Tanggal </th>
			<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color: white;"> Suplier </th>
			<th style="background-color: #4CAF50; color: white;"> Total </th>
			<th style="background-color: #4CAF50; color: white;"> Tanggal Jatuh Tempo </th>
			<th style="background-color: #4CAF50; color: white;"> Jam </th>
			<th style="background-color: #4CAF50; color: white;"> User </th>
			<th style="background-color: #4CAF50; color: white;"> Status </th>
			<th style="background-color: #4CAF50; color: white;"> Potongan </th>
			<th style="background-color: #4CAF50; color: white;"> Tax </th>
			<th style="background-color: #4CAF50; color: white;"> Kembalian</th>
			<th style="background-color: #4CAF50; color: white;"> Sisa Kredit </th>
			<th style="background-color: #4CAF50; color: white;"> Nilai Kredit </th>
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))

			{
				//menampilkan data
			echo "
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['tanggal_jt'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			<td>". rp($data1['kredit']) ."</td>
			<td>". rp($data1['nilai_kredit']) ."</td>
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   

		?>
		</tbody>

	</table>
</div>
<br>

       <a href='cetak_laporan_pembelian_hutang.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>' class='btn btn-success' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Pembelian Hutang</a>

</div>

<h3> Subtotal Hutang :  Rp. <?php echo rp($total_hutang); ?></h3>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>