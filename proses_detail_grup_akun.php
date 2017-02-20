<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$kode_grup_akun = $_POST['kode_grup_akun'];


$query = $db->query("SELECT * FROM daftar_akun WHERE grup_akun = '$kode_grup_akun'");



?>
					<div class="container">
					
					<div class="table-responsive"> 
					<table id="tableuser" class="table table-bordered">
					<thead>

					<th> Kode Akun </th>
					<th> Nama Akun </th>
					<th> Group Akun </th>
					<th> Kategori Akun</th>
					<th> Tipe Akun </th>
					
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['kode_daftar_akun'] ."</td>
					<td>". $data1['nama_daftar_akun'] ."</td>
					<td>". $data1['grup_akun'] ."</td>
					<td>". $data1['kategori_akun'] ."</td>
					<td>". $data1['tipe_akun'] ."</td>
					</tr>";

					}
					
					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>

					</tbody>
					
					</table>
					</div>
					</div>