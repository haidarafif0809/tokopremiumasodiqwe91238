<?php 
include 'sanitasi.php';
include 'db.php';



$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$query = $db->query("SELECT * FROM detail_kas_keluar WHERE tanggal >= '$sampai_tanggal' AND ke_akun = 'Goodwill'");



?>
					<h4><b><center> Transaksi Kas Keluar</center></b></h4>
					<table id="tableuser" class="table table-bordered">
					<thead>
					<th> Nomor Faktur </th>
					<th> Keterangan </th>
					<th> Dari Akun </th>
					<th> Ke Akun </th>
					<th> Jumlah </th>
					<th> Tanggal </th>
					<th> Jam </th>
					<th> User </th>	
					
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{
					
					
					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur'] ."</td>
					<td>". $data1['keterangan'] ."</td>
					<td>". $data1['dari_akun'] ."</td>
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
					
					</table>