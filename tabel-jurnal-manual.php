<?php include 'session_login.php';

include 'db.php';

//menampilkan seluruh data yang ada pada tabel jabatan
$query = $db->query("SELECT * FROM jurnal_trans WHERE jenis_transaksi = 'Jurnal Manual' AND debit = '0'");


$pilih_akses_akuntansi = $db->query("SELECT * FROM otoritas_laporan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$akuntansi = mysqli_fetch_array($pilih_akses_akuntansi);
 ?>



<table id="tableuser" class="table table-bordered">
		<thead> 
			
			
<?php  
if ($akuntansi['transaksi_jurnal_manual_hapus'] > 0) {
			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
		}
?>

<?php 
if ($akuntansi['transaksi_jurnal_manual_edit'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
    }
 ?>			
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Jenis Transaksi</th>
			<th style='background-color: #4CAF50; color:white'> User Buat</th>
			<th style='background-color: #4CAF50; color:white'> User Edit</th>
			<th style='background-color: #4CAF50; color:white'> Waktu Jurnal </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan Jurnal </th>

		</thead>
		
		<tbody>
		<?php

		// menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
			
if ($akuntansi['transaksi_jurnal_manual_hapus'] > 0) {

			echo "<tr class='tr-id-".$data['id']."'>

			<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-jurnal='". $data['jenis_transaksi'] ."' data-faktur='". $data['no_faktur'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}

if ($akuntansi['transaksi_jurnal_manual_edit'] > 0) {
			echo "<td> <a href='proses_edit_jurnal_manual.php?no_faktur=". $data['no_faktur']."&session_id=". $session_id ."' class='btn btn-success'> <span class='glyphicon glyphicon-edit'></span> Edit </a> </td>";

	echo "
		<td>".$data['no_faktur']."</td>
		<td>".$data['jenis_transaksi']."</td>
		<td>".$data['user_buat']."</td>
		<td>".$data['user_edit']."</td>
		<td>".$data['waktu_jurnal']."</td>
		<td>".$data['keterangan_jurnal']."</td>

</tr>";
			}
	}

	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>

		</tbody>

	</table>

	<script>
    $(document).ready(function(){

	
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nomor_jurnal = $(this).attr("data-jurnal");
		var nomor_faktur = $(this).attr("data-faktur");
		var id = $(this).attr("data-id");
		$("#no_jurnal").val(nomor_jurnal);
		$("#jenis_transaksi").val(nomor_faktur);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var no_faktur = $("#jenis_transaksi").val();

		$.post("hapus_jurnal_trans.php",{no_faktur:no_faktur},function(data){

		if (data != "") {
		$("#table_baru").load('tabel-jurnal-manual.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

									

		function tutupmodal() {
		
		}	
		});
		


		$('form').submit(function(){
		
		return false;
		});
		


		function tutupalert() {
		$(".alert").hide("fast")
		}
		

</script>


<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>