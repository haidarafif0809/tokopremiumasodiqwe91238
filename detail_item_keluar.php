<?php 

include 'sanitasi.php';
include 'db.php';


 $no_faktur = stringdoang($_POST['no_faktur']);

 $query = $db->query ("SELECT no_faktur,kode_barang,nama_barang,jumlah,satuan.nama AS satuan,harga,subtotal FROM detail_item_keluar INNER JOIN satuan ON detail_item_keluar.satuan = satuan.id WHERE no_faktur = '$no_faktur'");

 ?>

<div class="container">



<div class="table-responsive">      
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nomor Faktur </th>
			<th> Kode Barang </th>
			<th> Nama Barang </th>
			<th> Jumlah </th>
			<th> Satuan </th>
			<th> Harga </th>
			<th> Subtotal </th>
						

			
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
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['satuan'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($data1['subtotal']) ."</td>
			


			</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 			
		?>
		</tbody>

	</table>
</div>  

</div><!--end of container-->

