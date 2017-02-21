<?php 

include 'sanitasi.php';
include 'db.php';


 $no_faktur = $_POST['no_faktur'];

 $query = $db->query ("SELECT * FROM detail_stok_opname WHERE no_faktur = '$no_faktur'");

 ?>


<div class="container">



<div class="table-responsive">       
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nomor Faktur </th>
			<th> Kode Barang </th>
			<th> Nama Barang </th>
			<th> Stok Komputer </th>
			<th> Fisik </th>
			<th> Selisih Fisik </th>
			<th> Hpp </th>
			<th> Selisih Harga </th>

			
			
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
			<td>". $data1['stok_sekarang'] ."</td>
			<td>". rp($data1['fisik']) ."</td>
			<td>". rp($data1['selisih_fisik']) ."</td>
			<td>". rp($data1['hpp']) ."</td>
			<td>". rp($data1['selisih_harga']) ."</td>

			</tr>";
			}

			//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
		?>
		</tbody>

	</table>
</div> 

</div><!--end of container-->

