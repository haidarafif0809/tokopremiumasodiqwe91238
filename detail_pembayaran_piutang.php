<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur_pembayaran = $_POST['no_faktur_pembayaran'];


$query = $db->query("SELECT * FROM detail_pembayaran_piutang WHERE no_faktur_pembayaran = '$no_faktur_pembayaran'");



?>
					<div class="container">
					
					<div class="table-responsive">
					<table id="tableuser" class="table table-bordered">
					<thead>
					<th> Nomor Faktur Pembayaran</th>
					<th> Nomor Faktur Penjualan </th>
					<th> Tanggal </th>
					<th> Tanggal Jatuh Tempo </th>
					<th> Kredit </th>
					<th> Potongan </th>
					<th> Total </th>
					<th> Jumlah Bayar </th>
					</thead>
					
					
					<tbody>
					
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur_pembayaran'] ."</td>
					<td>". $data1['no_faktur_penjualan'] ."</td>
					<td>". $data1['tanggal'] ."</td>
					<td>". $data1['tanggal_jt'] ."</td>
					<td>". $data1['kredit'] ."</td>
					<td>". rp($data1['potongan']) ."</td>
					<td>". rp($data1['total']) ."</td>
					<td>". rp($data1['jumlah_bayar']) ."</td>
					</tr>";
					}
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 					
					?>
					
					</tbody>
					</table>
					</div>
					</div>