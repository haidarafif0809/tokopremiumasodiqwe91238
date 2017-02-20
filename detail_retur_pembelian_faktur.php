<?php 

include 'sanitasi.php';
include 'db.php';


 $no_faktur_retur = $_POST['no_faktur_retur'];

 $query = $db->query ("SELECT tp.id,tp.no_faktur_retur,tp.no_faktur_pembelian,tp.kode_barang,tp.nama_barang,tp.jumlah_beli,tp.jumlah_retur,tp.harga,tp.potongan,tp.tax,tp.subtotal, s.nama AS satuan_dasar, ss.nama AS satuan_beli FROM detail_retur_pembelian tp INNER JOIN barang bb ON tp.kode_barang = bb.kode_barang INNER JOIN satuan s ON bb.satuan = s.id INNER JOIN satuan ss ON tp.asal_satuan = ss.id WHERE tp.no_faktur_retur = '$no_faktur_retur'");

 ?>


<div class="container">



        
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nomor Faktur Retur </th>
			<th> Nomor Faktur Pembelian </th>
			<th> Kode Barang </th>
			<th> Nama Barang </th>
			<th> Jumlah Beli </th>
			<th> Jumlah Retur </th>
			<th> Satuan </th>
			<th> Harga </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> Subtotal </th>

			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['no_faktur_pembelian'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". rp($data1['jumlah_beli']) ." ".$data1['satuan_beli']."</td>
			<td>". rp($data1['jumlah_retur']) ."</td>
			<td>". $data1['satuan_dasar'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>

			
			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>


</div><!--end of container-->
