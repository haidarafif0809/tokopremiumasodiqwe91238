<?php session_start();


//memasukkan file session login, header, navbar, db.php
include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM retur_pembelian");

 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Detail </th>

<?php
include 'db.php';

$pilih_akses_retur_pembelian_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Retur Pembelian'");
$retur_pembelian_edit = mysqli_num_rows($pilih_akses_retur_pembelian_edit);

    if ($retur_pembelian_edit > 0) {
    	echo "<th> Edit </th>";
   }
?>

<?php
include 'db.php';

$pilih_akses_retur_pembelian_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Retur Pembelian'");
$retur_pembelian_hapus = mysqli_num_rows($pilih_akses_retur_pembelian_hapus);

    if ($retur_pembelian_hapus > 0) {
    	echo "<th> Hapus </th>";
   }
?>

			<th> Cetak </th>
			<th> Nomor Faktur Retur </th>
			<th> Tanggal </th>
			<th> Nama Suplier </th>
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

$pilih_akses_retur_pembelian_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Retur Pembelian'");
$retur_pembelian_edit = mysqli_num_rows($pilih_akses_retur_pembelian_edit);

    if ($retur_pembelian_edit > 0) {

			echo "<td> <a href='proses_edit_retur_pembelian.php?no_faktur_retur=". $data1['no_faktur_retur']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td> ";
		}

include 'db.php';

$pilih_akses_retur_pembelian_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Retur Pembelian'");
$retur_pembelian_hapus = mysqli_num_rows($pilih_akses_retur_pembelian_hapus);

    if ($retur_pembelian_hapus > 0) {
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-suplier='". $data1['nama_suplier'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		} 
			
			echo "<td> <a href='cetak_lap_retur_pembelian.php?no_faktur_retur=".$data1['no_faktur_retur']."' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print'> </span> Cetak Retur</a> </td>
			<td>". $data1['no_faktur_retur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['nama_suplier'] ."</td>
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

	<script>
		
		$(document).ready(function(){
		$('#tableuser').DataTable();
		});

				$(".detail").click(function(){
		var no_faktur_retur = $(this).attr('no_faktur_retur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_retur_pembelian.php',{no_faktur_retur:no_faktur_retur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});

		</script>

		<script type="text/javascript">
			
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var kode_suplier = $(this).attr("data-suplier");
		var id = $(this).attr("data-id");
		$("#data_suplier").val(kode_suplier);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		$.post("hapus_data_retur_pembelian.php",{id:id},function(data){
		if (data == 'sukses') {
		$("#tabel_baru").load('tabel-retur-pembelian.php');
		$("#modal_hapus").modal('hide');
		
		}
		
		});
		
		
		});


		</script>