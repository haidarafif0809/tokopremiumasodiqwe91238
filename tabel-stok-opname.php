<?php session_start();


include 'sanitasi.php';
include 'db.php';

//menampilkan seluruh data yang ada pada tabel pembelian dalan DB
$perintah = $db->query("SELECT * FROM stok_opname");




 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nomor Faktur </th>
			<th> Tanggal </th>
			<th> Jam </th>
			<th> Status </th>
			<th> Keterangan </th>
			<th> Total Selisih</th>
			
			<th> User </th>
			<th> Detail </th>

<?php
include 'db.php';

$pilih_akses_persediaan_stok_opname_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Persediaan Stok Opname'");
$persediaan_stok_opname_hapus = mysqli_num_rows($pilih_akses_persediaan_stok_opname_hapus);

    if ($persediaan_stok_opname_hapus > 0) {

				echo "<th> Hapus </th>";
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
			<td>". $data1['no_faktur'] ."</td>
			<td>". $data1['tanggal'] ."</td>
			<td>". $data1['jam'] ."</td>
			<td>". $data1['status'] ."</td>
			<td>". $data1['keterangan'] ."</td>
			<td>". rp($data1['total_selisih']) ."</td>
			
			<td>". $data1['user'] ."</td>

			<td> <button class='btn btn-info detail' no_faktur='". $data1['no_faktur'] ."' ><span class='glyphicon glyphicon-th-list'></span> Detail </button> </td>";

include 'db.php';

$pilih_akses_persediaan_stok_opname_hapus = $db->query("SELECT fungsi FROM akses WHERE otoritas = '$_SESSION[otoritas]' AND fungsi = 'Hapus' AND akses = 'Persediaan Stok Opname'");
$persediaan_stok_opname_hapus = mysqli_num_rows($pilih_akses_persediaan_stok_opname_hapus);

    if ($persediaan_stok_opname_hapus > 0) {
    	
				echo "<td> <button class='btn btn-danger btn-hapus' data-faktur='". $data1['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
			}
			
			
			echo "</tr>";
			}

				//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>


<script>

// untk menampilkan datatable atau filter seacrh
$(document).ready(function(){
    $('#tableuser').DataTable();
});

</script>

<script type="text/javascript">
	
	//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var no_faktur = $(this).attr("data-faktur");
		
		$("#data_faktur").val(no_faktur);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var no_faktur = $("#data_faktur").val();
		$.post("hapussatuan.php",{no_faktur:no_faktur},function(data){
		if (data != "") {
		$("#table_baru").load('tabel-stok-opname.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

</script>