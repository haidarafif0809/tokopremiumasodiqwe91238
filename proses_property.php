<?php 

include 'db.php';

include 'sanitasi.php';


$sampai_tanggal = stringdoang($_POST['sampai_tanggal']);



$query = $db->query("SELECT * FROM detail_kas_keluar WHERE tanggal >= '$sampai_tanggal' AND ke_akun = 'Property'");

$query1 = $db->query("SELECT * FROM detail_kas_masuk WHERE tanggal >= '$sampai_tanggal' AND ke_akun = 'Property'");



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
					while ($cek = mysqli_fetch_array($query))
					{
					
					
					//menampilkan data
					echo "<tr>
					<td>". $cek['no_faktur'] ."</td>
					<td>". $cek['keterangan'] ."</td>
					<td>". $cek['dari_akun'] ."</td>
					<td>". $cek['ke_akun'] ."</td>
					<td>". $cek['jumlah'] ."</td>
					<td>". $cek['tanggal'] ."</td>
					<td>". $cek['jam'] ."</td>
					<td>". $cek['user'] ."</td>
					</tr>";
					}
					?>
					</tbody>
					
					</table>

					<br>
					<h4><b><center> Transaksi Kas Masuk</center></b></h4>
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
					while ($data = mysqli_fetch_array($query1))
					{
					
					
					//menampilkan data
					echo "<tr>
					<td>". $data['no_faktur'] ."</td>
					<td>". $data['keterangan'] ."</td>
					<td>". $data['dari_akun'] ."</td>
					<td>". $data['ke_akun'] ."</td>
					<td>". $data['jumlah'] ."</td>
					<td>". $data['tanggal'] ."</td>
					<td>". $data['jam'] ."</td>
					<td>". $data['user'] ."</td>
					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>