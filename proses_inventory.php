<?php 
include 'sanitasi.php';
include 'db.php';


$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$query = $db->query("SELECT * FROM pembelian WHERE tanggal >= '$sampai_tanggal'");

$query1 = $db->query("SELECT * FROM penjualan WHERE tanggal >= '$sampai_tanggal'");

?>
				<h4> <b> <center>Pembelian</center> </b> </h4>
				<table id="tableuser" class="table table-bordered">
				<thead>
				<th> Nomor Faktur </th>
				<th> Suplier </th>
				<th> Total </th>
				<th> Tanggal </th>
				<th> Tanggal Jatuh Tempo </th>
				<th> Jam </th>
				<th> User </th>
				<th> Status </th>
				<th> Potongan </th>
				<th> Tax </th>
				<th> Sisa </th>
				
				
				</thead>
				
				<tbody>
				<?php
				
				//menyimpan data sementara yang ada pada $perintah
				while ($data1 = mysqli_fetch_array($query))
				{
				//menampilkan data
				echo "<tr>
				<td>". $data1['no_faktur'] ."</td>
				<td>". $data1['suplier'] ."</td>
				<td>". rp($data1['total']) ."</td>
				<td>". $data1['tanggal'] ."</td>
				<td>". $data1['tanggal_jt'] ."</td>
				<td>". $data1['jam'] ."</td>
				<td>". $data1['user'] ."</td>
				<td>". $data1['status'] ."</td>
				<td>". rp($data1['potongan']) ."</td>
				<td>". rp($data1['tax']) ."</td>
				<td>". rp($data1['sisa']) ."</td>
				
				</tr>";
				}
				?>
				</tbody>
				
				</table>


				<br>
				<h4> <b> <center>Penjualan</center> </b> </h4>
				<table id="tableuser" class="table table-bordered">
				<thead>
				<th> Nomor Faktur </th>
				<th> Kode Pelanggan</th>
				<th> Total </th>
				<th> Tanggal </th>
				<th> Jam </th>
				<th> User </th>
				<th> Status </th>
				<th> Potongan </th>
				<th> Tax </th>
				<th> Sisa </th>
				<th> Total Hpp </th>
				
			
				
				
				</thead>
				
				<tbody>
				<?php
				
				//menyimpan data sementara yang ada pada $perintah
				while ($cek = mysqli_fetch_array($query1))
				{
				//menampilkan data
				echo "<tr>
				<td>". $cek['no_faktur'] ."</td>
				<td>". $cek['kode_pelanggan'] ."</td>
				<td>". rp($cek['total']) ."</td>
				<td>". $cek['tanggal'] ."</td>
				<td>". $cek['jam'] ."</td>
				<td>". $cek['user'] ."</td>
				<td>". $cek['status'] ."</td>
				<td>". rp($cek['potongan']) ."</td>
				<td>". rp($cek['tax']) ."</td>
				<td>". rp($cek['sisa']) ."</td>
				<td>". rp($cek['total_hpp']) ."</td>
				
				
				
				</tr>";
				}

				//Untuk Memutuskan Koneksi Ke Database
				mysqli_close($db);   
				?>
				</tbody>
				
				</table>

				<h5><i>*Note : <br><br> Inventory = Jumlah Total (Pembelian) - Jumlah Total Hpp (Penjualan)</i></h5>