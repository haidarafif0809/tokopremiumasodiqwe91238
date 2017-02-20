<?php session_start();


//memasukkan file session login, header, navbar, db.php
include 'db.php';
include 'sanitasi.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM item_keluar");

 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> User Edit </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Edit </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php
if ($item_masuk['item_keluar_edit'] > 0) {

				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
		}
?>

<?php
if ($item_masuk['item_keluar_hapus'] > 0) {
			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
		}

?>
		
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{

			echo "<tr class='tr-id-".$data1['id']."'>
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['user_edit'] ."</td>
			<td>". $data1['tanggal_edit'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". rp($data1['total']) ."</td>

			<td> <button class='btn btn-info detail' no_faktur='". $data1['no_faktur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

include 'db.php';

if ($item_masuk['item_keluar_edit'] > 0) {
			 	echo "<td> <a href='proses_edit_item_keluar.php?no_faktur=". $data1['no_faktur']."' class='btn btn-success'>  Edit </i></a> </td>";
			 }

if ($item_masuk['item_keluar_hapus'] > 0) {

			echo "<td> <button class='btn btn-danger btn-hapus' data-item='". $data1['no_faktur'] ."' data-id='". $data1['id'] ."'>Hapus </button> </td> 
			
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
		
		$.post('detail_item_keluar.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
</script>

	<script>
			
	//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama_item = $(this).attr("data-item");
		$("#data_faktur").val(nama_item);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var no_faktur = $("#data_faktur").val();
		$.post("hapus_item_keluar.php",{no_faktur:no_faktur},function(data){


		$("#modal_hapus").modal('hide');

		
	

		
		});
		
		});
// end fungsi hapus data

		</script>