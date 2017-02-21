<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM halaman_promo");

 ?>

  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<h3><b> DATA SETTING PROMO </b></h3><hr>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Nama Promo</th>
			<th style='background-color: #4CAF50; color: white'> Keterangan Promo</th>

<?php
$pilih_akses_perusahaan_edit = $db->query("SELECT set_perusahaan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND set_perusahaan_edit = '1'");
$perusahaan_edit = mysqli_num_rows($pilih_akses_perusahaan_edit);

    if ($perusahaan_edit > 0) {	
			echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
	}
	?>

			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>
			<td>". $data1['nama_promo'] ."</td>
			<td>". $data1['keterangan_promo'] ."</td>";

$pilih_akses_perusahaan_edit = $db->query("SELECT set_perusahaan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND set_perusahaan_edit = '1'");
$perusahaan_edit = mysqli_num_rows($pilih_akses_perusahaan_edit);

   if ($perusahaan_edit > 0) {	
			echo "<td> <a href='edit_halaman_promo.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> </td>
			</tr>";
		}
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>

					</tbody>

	</table>
</div>
</div>
		<script>
		
		$(document).ready(function(){
		$('#tableuser').dataTable();
		});
		</script>

<?php 
include 'footer.php';
 ?>