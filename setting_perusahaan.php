<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM perusahaan");

 ?>

  <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<div class="container">

<h3><b> DATA PERUSAHAAN </b></h3><hr>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'> Nama Perusahaan</th>
			<th style='background-color: #4CAF50; color: white'> Alamat Perusahaan</th>
			<th style='background-color: #4CAF50; color: white'> Singkatan Perusahaan </th>
			<th style='background-color: #4CAF50; color: white'> Foto </th>
			<th style='background-color: #4CAF50; color: white'> Nomor Telepon </th>
			<th style='background-color: #4CAF50; color: white'> Nomor Fax </th>

<?php
include 'db.php';

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
			<td>". $data1['nama_perusahaan'] ."</td>
			<td>". $data1['alamat_perusahaan'] ."</td>
			<td>". $data1['singkatan_perusahaan'] ."</td>
			<td><img src='save_picture/". $data1['foto'] ."' height='30px' width='40px'></td>
			<td>". $data1['no_telp'] ."</td>
			<td>". $data1['no_fax'] ."</td>";

include 'db.php';

$pilih_akses_perusahaan_edit = $db->query("SELECT set_perusahaan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND set_perusahaan_edit = '1'");
$perusahaan_edit = mysqli_num_rows($pilih_akses_perusahaan_edit);

    if ($perusahaan_edit > 0) {	
			echo "<td> <a href='edit_perusahaan.php?id=". $data1['id']."' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Edit</a> </td>
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