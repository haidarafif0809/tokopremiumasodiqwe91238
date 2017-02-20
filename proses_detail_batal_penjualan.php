<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];


$query = $db->query("SELECT * FROM batal_detail_penjualan WHERE no_faktur = '$no_faktur'");



?>
		<div class="container">
					
					<div class="table-responsive"> 
					<table id="tableuser" class="table table-bordered">
					<thead>
					<th> Nomor Faktur </th>
					<th> Kode Barang </th>
					<th> Nama Barang </th>
					<th> Jumlah Barang </th>
					<th> Satuan </th>
					<th> Harga </th>
					<th> Subtotal </th>
					<th> Potongan </th>
					<th> Tax </th>
					<th> Hpp </th>
             		<th> Sisa Barang </th>
             		<th> Keterangan </th>
					
					
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{
					//menampilkan data
					echo "<tr>
					<td>". $data1['no_faktur'] ."</td>
					<td>". $data1['kode_barang'] ."</td>
					<td>". $data1['nama_barang'] ."</td>
					<td>". $data1['jumlah_barang'] ."</td>
					<td>". $data1['satuan'] ."</td>
					<td>". rp($data1['harga']) ."</td>
					<td>". rp($data1['subtotal']) ."</td>
					<td>". rp($data1['potongan']) ."</td>
					<td>". rp($data1['tax']) ."</td>
					<td>". rp($data1['hpp']) ."</td>
					<td>". $data1['sisa'] ."</td>
					<td>". $data1['batal_detail_penjualan'] ."</td>
					</tr>";

					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>
					</div>
					</div>