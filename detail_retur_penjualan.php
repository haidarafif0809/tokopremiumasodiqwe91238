<?php 

include 'sanitasi.php';
include 'db.php';


 $no_faktur_retur = $_POST['no_faktur_retur'];

 $query = $db->query ("SELECT dp.jumlah_retur / IFNULL( sk.konversi,0) AS jumlah_produk ,sa.nama AS satuan_jual ,sk.konversi,dp.no_faktur_penjualan, dp.no_faktur_retur, dp.id, dp.nama_barang, dp.kode_barang, dp.jumlah_beli, dp.jumlah_retur, dp.harga, dp.potongan, dp.tax,
  dp.subtotal, sk.id_satuan, s.nama, dp.jumlah_retur FROM detail_retur_penjualan dp LEFT JOIN satuan_konversi sk ON dp.kode_barang = sk.kode_produk AND dp.satuan = sk.id_satuan 
  LEFT JOIN satuan s ON dp.satuan = s.id LEFT JOIN satuan sa ON dp.asal_satuan = sa.id WHERE dp.no_faktur_retur = '$no_faktur_retur'");

 ?>


<div class="container">



        
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nomor Faktur Retur </th>
			<th> Nomor Faktur Penjualan </th>
			<th> Nama Barang </th>
			<th> Kode Barang </th>
			<th> Jumlah Jual </th>
			<th> Jumlah Retur </th>
			<th> Satuan Retur </th>
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
			<td>". $data1['no_faktur_penjualan'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". rp($data1['jumlah_beli']) ." ". $data1['satuan_jual'] ."</td>";

			if ($data1['konversi'] != 0) {
				echo "<td>". $data1['jumlah_produk'] ."</td>";
			}
			else{
				echo "<td>". rp($data1['jumlah_retur']) ."</td>";
			}

			echo "

			<td>". $data1['nama'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>

		";


			echo "</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>


</div><!--end of container-->
