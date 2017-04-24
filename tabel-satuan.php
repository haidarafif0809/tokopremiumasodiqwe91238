<?php session_start();

include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

$query = $db->query("SELECT * FROM satuan");



 ?>


<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Satuan </th>
			

<?php 
include 'db.php';

$pilih_akses_satuan_hapus = $db->query("SELECT satuan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_hapus = '1'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			echo "<th> Hapus </th>";

		}
?>

<?php 
include 'db.php';

$pilih_akses_satuan_edit = $db->query("SELECT satuan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_edit = '1'");
$satuan_edit = mysqli_num_rows($pilih_akses_satuan_edit);


    if ($satuan_edit > 0){
			echo "<th> Edit </th>";
		}
?>
			
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($query))
			{
			echo "<tr class='tr-id-".$data['id']."'>
			<td>". $data['nama'] ."</td>";
			

include 'db.php';

$pilih_akses_satuan_hapus = $db->query("SELECT satuan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_hapus = '1'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-satuan='". $data['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}

include 'db.php';

$pilih_akses_satuan_edit = $db->query("SELECT satuan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_edit = '1'");
$satuan_edit = mysqli_num_rows($pilih_akses_satuan_edit);


    if ($satuan_edit > 0){
			

			echo "<td><button class='btn btn-success btn-edit' data-satuan='". $data['nama'] ."' data-id='". $data['id'] ."' > <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

			</tr>";
		}
			}
		?>
		</tbody>

	</table>



<script type="text/javascript">
    $(document).ready(function(){


	
//fungsi hapus data 
$(document).on('click', '.btn-hapus', function (e) {
		var nama_satuan = $(this).attr("data-satuan");
		var id = $(this).attr("data-id");
		$("#data_satuan").val(nama_satuan);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


$(document).on('click', '#btn_jadi_hapus', function (e) {
		
		var id = $("#id_hapus").val();
		$.post("hapussatuan.php",{id:id},function(data){
		if (data != "") {
		
		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id+"").remove();
		
		}

		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-satuan"); 
		var id  = $(this).attr("data-id");
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#nama_edit").val();
		var id = $("#id_edit").val();
		$.post("updatesatuan.php",{id:id,nama:nama},function(data){
		if (data == 'sukses') {
		$(".alert").show('fast');
		$("#table-baru").load('tabel-satuan.php');
		setTimeout(tutupmodal, 2000);
		setTimeout(tutupalert, 2000);
		
		}
		});
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		
		function tutupmodal() {
		$(".modal").modal("hide")
		}
		function tutupalert() {
		$(".alert").hide("fast")
		}
		


</script>


<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>




