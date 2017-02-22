<?php session_start();



include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM item_masuk");




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
include 'db.php';

$pilih_akses_persediaan_item_masuk_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Persediaan Item Masuk'");
$persediaan_item_masuk_edit = mysqli_num_rows($pilih_akses_persediaan_item_masuk_edit);

    if ($persediaan_item_masuk_edit > 0) {

				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";

			}
?>

<?php
include 'db.php';

$pilih_akses_persediaan_item_masuk_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Persediaan Item Masuk'");
$persediaan_item_masuk_hapus = mysqli_num_rows($pilih_akses_persediaan_item_masuk_hapus);

    if ($persediaan_item_masuk_hapus > 0) {
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
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['user_edit'] ."</td>
			<td>". $data1['tanggal_edit'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". rp($data1['total']) ."</td>


			<td> <button class='btn btn-info detail' no_faktur='". $data1['no_faktur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

include 'db.php';

$pilih_akses_persediaan_item_masuk_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Persediaan Item Masuk'");
$persediaan_item_masuk_edit = mysqli_num_rows($pilih_akses_persediaan_item_masuk_edit);

    if ($persediaan_item_masuk_edit > 0) {
			 	echo "<td> <a href='proses_edit_item_masuk.php?no_faktur=". $data1['no_faktur']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";
			 }


include 'db.php';

$pilih_akses_persediaan_item_masuk_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Persediaan Item Masuk'");
$persediaan_item_masuk_hapus = mysqli_num_rows($pilih_akses_persediaan_item_masuk_hapus);

    if ($persediaan_item_masuk_hapus > 0) {

$hpp_keluar = $db->query ("SELECT no_faktur FROM hpp_keluar WHERE no_faktur_hpp_masuk = '$data1[no_faktur]'");
$row_hpp_keluar = mysqli_num_rows($hpp_keluar);

		
		if ($row_hpp_keluar > 0 ) 
		{

			echo"<td> <button class='btn btn-danger btn-alert' data-faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";

		} 

		else
		{

			echo"<td> <button class='btn btn-danger btn-hapus' data-id='".$data1['id']."' data-item='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";			
		
		}
			
			echo "</tr>";
			}
	
}

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

<br>
	<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
		<span id="demo"> </span>
</div><!--end of container-->
		

		<!--menampilkan detail penjualan-->
		<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});
		
		
		$(".detail").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_item_masuk.php',{no_faktur:no_faktur},function(info) {
		
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
		$.post("hapus_item_masuk.php",{no_faktur:no_faktur},function(data){
		

		$("#modal_hapus").modal('hide');

		
	

		
		});
		
		});
// end fungsi hapus data

		</script>