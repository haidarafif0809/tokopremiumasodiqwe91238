<?php session_start();


include 'sanitasi.php';
include 'db.php';

$dari_tanggal = stringdoang($_POST['dari_tanggal']);
$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);


//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT s.nama,dp.id,dp.no_faktur,dp.kode_barang,dp.nama_barang,dp.jumlah_barang,dp.satuan,dp.harga,dp.subtotal,dp.potongan,dp.tax,dp.sisa, ss.nama AS asal_satuan FROM detail_pembelian dp INNER JOIN satuan s ON dp.satuan = s.id INNER JOIN satuan ss ON dp.asal_satuan = ss.id WHERE dp.tanggal >= '$dari_tanggal' AND dp.tanggal <= '$sampai_tanggal'");





$query15 = $db->query("SELECT SUM(subtotal) AS total_subtotal FROM 
detail_pembelian WHERE tanggal >= '$dari_tanggal' AND tanggal <= '$sampai_tanggal'");
$cek15 = mysqli_fetch_array($query15);
$t_subtotal = $cek15['total_subtotal'];



 ?>

 <style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="card card-block">

<div class="table-responsive">
					<table id="tableuser" class="table table-bordered">
					<thead>
					<th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
					<th style="background-color: #4CAF50; color: white;"> Kode Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Nama Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Jumlah Barang </th>
					<th style="background-color: #4CAF50; color: white;"> Satuan </th>
					<th style="background-color: #4CAF50; color: white;"> Harga </th>
					<th style="background-color: #4CAF50; color: white;"> Subtotal </th>
					<th style="background-color: #4CAF50; color: white;"> Potongan </th>
					<th style="background-color: #4CAF50; color: white;"> Tax </th>
					<th style="background-color: #4CAF50; color: white;"> Sisa Barang </th>
					</thead>


					<tbody>

					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($perintah))
					{

						$pilih_konversi = $db->query("SELECT $data1[jumlah_barang] / sk.konversi AS jumlah_konversi, sk.harga_pokok / sk.konversi AS harga_konversi, sk.id_satuan, b.satuan FROM satuan_konversi sk INNER JOIN barang b ON sk.id_produk = b.id  WHERE sk.id_satuan = '$data1[satuan]' AND sk.kode_produk = '$data1[kode_barang]'");
					      $data_konversi = mysqli_fetch_array($pilih_konversi);

					      if ($data_konversi['harga_konversi'] != 0 || $data_konversi['harga_konversi'] != "") {
					        
					         $jumlah_barang = $data_konversi['jumlah_konversi'];
					      }
					      else{
					        $jumlah_barang = $data1['jumlah_barang'];
					      }

					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur'] ."</td>
					<td>". $data1['kode_barang'] ."</td>
					<td>". $data1['nama_barang'] ."</td>
					<td>". $jumlah_barang ."</td>
					<td>". $data1['nama'] ."</td>
					<td>". rp($data1['harga']) ."</td>
					<td>". rp($data1['subtotal']) ."</td>
					<td>". rp($data1['potongan']) ."</td>
					<td>". rp($data1['tax']) ."</td>
					<td>". rp($data1['sisa']) ." ". $data1['asal_satuan'] ."</td>
					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   

					?>

					</tbody>
					</table>
</div>

<br>

 <table>
  <tbody>
      <tr><td style="font-size: 30px" width="50%">Total</td> <td style="font-size: 30px"> :&nbsp; </td> <td style="font-size: 30px"> <?php echo rp($t_subtotal); ?> </td>
      </tr>
  </tbody>
  </table>
  <br><br>

       <a href='cetak_lap_pembelian_detail.php?dari_tanggal=<?php echo $dari_tanggal; ?>&sampai_tanggal=<?php echo $sampai_tanggal; ?>'
       class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Pembelian </a>

</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>