<?php session_start();


//memasukkan file session login, header, navbar, db.php
include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

$perintah = $db->query("SELECT km.id, km.no_faktur, km.keterangan, km.dari_akun, km.jumlah, km.tanggal, km.jam, km.user, da.nama_daftar_akun FROM kas_keluar km INNER JOIN daftar_akun da ON km.dari_akun = da.kode_daftar_akun");


 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Dari Akun </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php
if ($kas_keluar['kas_keluar_edit'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>

<?php
if ($kas_keluar['kas_keluar_hapus'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>

			

			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr class='tr-id-".$data1['id']."'>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['nama_daftar_akun'] ."</td>
			<td>". rp($data1['jumlah']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			

			<td> <button class=' btn btn-info detail' no_faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

if ($kas_keluar['kas_keluar_edit'] > 0) {

			echo "<td> <a href='proses_edit_data_kas_keluar.php?no_faktur=". $data1['no_faktur']."&nama_daftar_akun=". $data1['nama_daftar_akun']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";
		}

if ($kas_keluar['kas_keluar_hapus'] > 0) {

			echo "<td> <button class=' btn btn-danger btn-hapus' data-id='". $data1['id'] ."' no-faktur='". $data1['no_faktur'] ."'><span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 

			
			</tr>";
			}
	}
	//Untuk Memutuskan Koneksi Ke Database
	mysqli_close($db);   
		?>
		</tbody>

	</table>


	<script type="text/javascript">
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});

				$(".detail").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_kas_keluar.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
	</script>

 <script type="text/javascript">
			
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var no_faktur = $(this).attr("no-faktur");
		var id = $(this).attr("data-id");
		$("#hapus_no_faktur").val(no_faktur);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		$.post("hapus_kas_keluar.php",{id:id},function(data){
		if (data != "") {
		$("#tabel-baru").load('tabel-kas-keluar.php');
		$("#modal_hapus").modal('hide');
		
		}
		
		});
		
		
		});

</script>