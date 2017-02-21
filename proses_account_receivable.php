<?php 
include 'sanitasi.php';
include 'db.php';


$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$query = $db->query("SELECT * FROM penjualan WHERE tanggal >= '$sampai_tanggal' AND kredit != 0");



?>
				<h4><b><center>Transaksi Piutang (Penjualan)</center></b></h4>
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
					<th> Kredit </th>
				
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur'] ."</td>
					<td>". $data1['kode_pelanggan'] ."</td>
					<td>". rp($data1['total']) ."</td>
					<td>". $data1['tanggal'] ."</td>
					<td>". $data1['jam'] ."</td>
					<td>". $data1['user'] ."</td>
					<td>". $data1['status'] ."</td>
					<td>". rp($data1['potongan']) ."</td>
					<td>". rp($data1['tax']) ."</td>
					<td>". rp($data1['sisa']) ."</td>
					<td>". rp($data1['kredit']) ."</td>
					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>