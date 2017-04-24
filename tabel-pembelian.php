<?php session_start();


include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel penjualan
$perintah = $db->query("SELECT * FROM pembelian ORDER BY id DESC");

 ?>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->

<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Detail </th>

<?php 
include 'db.php';

$pilih_akses_pembelian_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Pembelian'");
$pembelian_edit = mysqli_num_rows($pilih_akses_pembelian_edit);


    if ($pembelian_edit > 0){
				echo "<th> Edit </th>";

			}
?>

<?php 
include 'db.php';

$pilih_akses_pembelian_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Pembelian'");
$pembelian_hapus = mysqli_num_rows($pilih_akses_pembelian_hapus);


    if ($pembelian_hapus > 0){
				echo "<th> Hapus </th>";
	}
	?>
			
			<th> Cetak Tunai </th>
			<th> Cetak Hutang </th>
			<th> Nomor Faktur </th>
			<th> Suplier </th>
			<th> Total </th>
			<th> Tanggal </th>
			<th> Tanggal Jatuh Tempo </th>
			<th> Jam </th>
			<th> User </th>
			<th> Status </th>
			<th> Potongan </th>
			<th> Tax </th>
			<th> Kembalian</th>
			<th> Kredit </th>
			
			
			
			
		</thead>
		
		<tbody>
		<?php

			//menyimpan data sementara yang ada pada $perintah
			while ($data1 = mysqli_fetch_array($perintah))
			{
				//menampilkan data
			echo "<tr>
			<td> <button class='btn btn-info detail' no_faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

		

include 'db.php';

$pilih_akses_pembelian_edit = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Edit' AND akses = 'Pembelian'");
$pembelian_edit = mysqli_num_rows($pilih_akses_pembelian_edit);


    if ($pembelian_edit > 0){
				echo "<td> <a href='proses_edit_pembelian.php?no_faktur=". $data1['no_faktur']."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>"; 
}


include 'db.php';

$pilih_akses_pembelian_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Pembelian'");
$pembelian_hapus = mysqli_num_rows($pilih_akses_pembelian_hapus);


    if ($pembelian_hapus > 0){
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='".$data1['id']."' data-suplier='".$data1['suplier']."'><span class='glyphicon glyphicon-trash'></span> Hapus  </button> </td>"; 
			}

			

			if ($data1['status'] == 'Lunas') {

			echo "<td> <a href='cetak_lap_pembelian_tunai.php?no_faktur=".$data1['no_faktur']."' id='cetak_tunai' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print' > </span> Cetak Tunai </a> </td>";
}

else{

	echo "<td> </td>";
	
}

			
if ($data1['status'] == 'Hutang'){
	echo "<td> <a href='cetak_lap_pembelian_hutang.php?no_faktur=".$data1['no_faktur']."' id='cetak_piutang' class='btn btn-primary' target='blank'><span class='glyphicon glyphicon-print' > </span> Cetak Hutang </a> </td>";
}

else {

	echo "<td> </td>";
}
			echo "<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['suplier'] ."</td>
			<td>". rp($data1['total']) ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['tanggal_jt'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['user'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". rp($data1['potongan']) ."</td>
			<td>". rp($data1['tax']) ."</td>
			<td>". rp($data1['sisa']) ."</td>
			<td>". rp($data1['kredit']) ."</td>
			</tr>";
			}

				//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>
</div>

<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
		<span id="demo"> </span>
		

<!--menampilkan detail penjualan-->
		<script>
		
		$(document).ready(function(){
		$('.table').DataTable({"ordering":false});
		});
		</script>



		<script type="text/javascript">
		
		$(".detail").click(function(){
		var no_faktur = $(this).attr('no_faktur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('proses_detail_pembelian.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>

		<script type="text/javascript">
						$(document).ready(function(){
						//fungsi hapus data 
						$(document).on('click', '.btn-hapus', function (e) {
						var suplier = $(this).attr("data-suplier");
						var id = $(this).attr("data-id");
						$("#nama_suplier").val(suplier);
						$("#id_hapus").val(id);
						$("#modal_hapus").modal('show');
						
						
						});
						});

		</script>
