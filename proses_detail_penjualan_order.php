<?php include 'session_login.php';

include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];

$detail = $db->query("SELECT * FROM detail_penjualan_order WHERE no_faktur_order = '$no_faktur'");

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
					
					</thead>
					
					<tbody>
					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($detail))
					{

						$query = $db->query("SELECT dp.id, dp.no_faktur_order, dp.kode_barang, dp.nama_barang, dp.jumlah_barang / sk.konversi AS jumlah_produk, dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, sk.id_satuan, s.nama FROM detail_penjualan_order dp LEFT JOIN satuan_konversi sk ON dp.satuan = sk.id_satuan LEFT JOIN satuan s ON dp.satuan = s.id  WHERE dp.no_faktur_order = '$no_faktur' AND dp.kode_barang = '$data1[kode_barang]' ");
						$data = mysqli_fetch_array($query);
						
					//menampilkan data
					echo "<tr>
					<td>". $data['no_faktur_order'] ."</td>
					<td>". $data['kode_barang'] ."</td>
					<td>". $data['nama_barang'] ."</td>";

					if ($data['jumlah_produk'] > 0) {
						echo "<td>". $data['jumlah_produk'] ."</td>";
					}
					else{
						echo "<td>". $data['jumlah_barang'] ."</td>";
					}

					echo"<td>". $data['nama'] ."</td>
					<td>". rp($data['harga']) ."</td>
					<td>". rp($data['subtotal']) ."</td>
					<td>". rp($data['potongan']) ."</td>
					<td>". rp($data['tax']) ."</td>

      
					</tr>";
					}

					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>
					</tbody>
					
					</table>
					</div>
					</div>