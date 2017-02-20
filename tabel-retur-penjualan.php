<?php session_start();



include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM retur_penjualan");




 ?>
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Detail </th>

<?php
include 'db.php';

$pilih_akses_retur_penjualan_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Retur Penjualan'");
$retur_penjualan_edit = mysqli_num_rows($pilih_akses_retur_penjualan_edit);

    if ($retur_penjualan_edit > 0) {
    	echo "<th> Edit </th>";
   }
?>

<?php
include 'db.php';

$pilih_akses_retur_penjualan_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Retur Penjualan'");
$retur_penjualan_hapus = mysqli_num_rows($pilih_akses_retur_penjualan_hapus);

    if ($retur_penjualan_hapus > 0) {
    	echo "<th> Hapus </th>";
   }
?>
			
			
			<th> Cetak </th>
			<th> Nomor Faktur Retur </th>
			<th> Tanggal </th>
			<th> Kode Pelanggan </th>
			<th> Total </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> User Buat </th>
			<th> User Edit </th>
			<th> Tanggal Edit</th>
			<th> Tunai </th>
			<th> Kembalian </th>

		</thead>

		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>

			<td> <button class='btn btn-info detail' no_faktur_retur='". $data1['no_faktur_retur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

include 'db.php';

$pilih_akses_retur_penjualan_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Retur Penjualan'");
$retur_penjualan_edit = mysqli_num_rows($pilih_akses_retur_penjualan_edit);

    if ($retur_penjualan_edit > 0) { 

			echo "<td> <a href='proses_edit_retur_penjualan.php?no_faktur_retur=". $data1['no_faktur_retur']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";
		}


include 'db.php';

$pilih_akses_retur_penjualan_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Retur Penjualan'");
$retur_penjualan_hapus = mysqli_num_rows($pilih_akses_retur_penjualan_hapus);

    if ($retur_penjualan_hapus > 0) {
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-pelanggan='". $data1['kode_pelanggan'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button>  </td>";

	}		
			echo "<td> <a href='cetak_lap_retur_penjualan.php?no_faktur_retur=".$data1['no_faktur_retur']."' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Retur</a> </td>

			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['kode_pelanggan'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". $data1['user_buat'] ."</td>
			<td>". $data1['user_edit'] ."</td>
			<td>". $data1['tanggal_edit'] ."</td>
			<td>". rp($data1['tunai']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			
			</tr>";
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
		var no_faktur_retur = $(this).attr('no_faktur_retur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_retur_penjualan.php',{no_faktur_retur:no_faktur_retur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>

				<script type="text/javascript">
				
				//fungsi hapus data 
				$(".btn-hapus").click(function(){
				var kode_pelanggan = $(this).attr("data-pelanggan");
				var id = $(this).attr("data-id");
				$("#data_pelanggan").val(kode_pelanggan);
				$("#id_hapus").val(id);
				$("#modal_hapus").modal('show');
				
				
				});
				
				$("#btn_jadi_hapus").click(function(){
				
				var id = $("#id_hapus").val();
				$.post("hapus_data_retur_penjualan.php",{id:id},function(data){
				if (data != "") {
				$("#tabel_baru").load('tabel-retur-penjualan.php');
				$("#modal_hapus").modal('hide');
				
				}
				
				});
				
				
				});
				
				
				</script>