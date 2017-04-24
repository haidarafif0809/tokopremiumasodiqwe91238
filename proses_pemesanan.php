<?php 

include 'sanitasi.php';
include 'db.php';


$kode_barang = $_POST['kode_barang'];


$query = $db->query("SELECT * FROM barang WHERE kode_barang = '$kode_barang'");


?>
					<div class="container">
					<table id="tableuser" class="table table-bordered">

					<tbody>

			<?php
					
				//menyimpan data sementara yang ada pada $query
					while ($data1 = mysqli_fetch_array($query))
					{
				//menampilkan data
						echo "<tr>
						<td><img src='save_picture/". $data1['foto'] ."' height='50px' width='80px'></td>
						<td>". $data1['kode_barang'] ."</td>
						<td>". $data1['nama_barang'] ."</td>
						<td>". $data1['jumlah_barang'] ."</td>
						<td>". rp($data1['harga_jual']) ."</td>
						
						
						</tr>";
					}
					
					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
			?>
					</tbody>
					
					</table>
					</div>