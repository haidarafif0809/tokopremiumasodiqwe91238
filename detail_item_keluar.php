<?php 

include 'sanitasi.php';
include 'db.php';


 $no_faktur = $_POST['no_faktur'];

 $query = $db->query ("SELECT *,st.nama as nama_satuan FROM detail_item_keluar dik LEFT JOIN satuan st ON dik.satuan = st.id  WHERE dik.no_faktur = '$no_faktur'");

 ?>

<div class="container">



<div class="table-responsive">      
<table id="tableuser" class="table table-bordered table-sm">
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
				
				$subtotal = $data1['jumlah'] * $data1['harga'];
				//menampilkan data
			echo "<tr>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['kode_barang'] ."</td>
			<td>". $data1['nama_barang'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['nama_satuan'] ."</td>
			<td>". rp($data1['harga']) ."</td>
			<td>". rp($subtotal) ."</td>
			


			</tr>";
			}

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 			
		?>
		</tbody>

	</table>
</div>  

</div><!--end of container-->

