<?php 
include 'sanitasi.php';
include 'db.php';

$no_faktur = $_POST['no_faktur'];





$query = $db->query("SELECT dp.id, dp.no_faktur, dp.kode_barang, dp.nama_barang, dp.jumlah_barang , dp.jumlah_barang, dp.satuan, dp.harga, dp.potongan, dp.subtotal, dp.tax, dp.sisa, s.nama, sa.nama AS satuan_asal FROM detail_pembelian dp LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN satuan sa ON dp.asal_satuan = sa.id WHERE dp.no_faktur = '$no_faktur'");



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
					<th> Potongan </th>
					<th> Subtotal </th>
					<th> Tax </th>
					<th> Sisa Barang </th>
					</thead>


					<tbody>

					<?php
					
					//menyimpan data sementara yang ada pada $perintah
					while ($data1 = mysqli_fetch_array($query))
					{

					$ambil_hpp = $db->query("SELECT SUM(sisa) AS sisa_hpp FROM hpp_masuk WHERE no_faktur = '$no_faktur' AND kode_barang = '$data1[kode_barang]'");
					$data_hpp = mysqli_fetch_array($ambil_hpp);

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
					<td>". $data_hpp['sisa_hpp'] ." ".$data1['satuan_asal']."</td>
					</tr>";
					}
					
					
					//Untuk Memutuskan Koneksi Ke Database
					mysqli_close($db);   
					?>

					</tbody>
					</table>
					</div>
					</div>