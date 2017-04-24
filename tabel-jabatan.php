<?php session_start();


include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

$query = $db->query("SELECT * FROM jabatan");



 ?>



<table id="tableuser" class="table table-bordered">
		<thead> 
			
			<th> Nama Jabatan </th>
			<th> Wewenang </th>
<?php  
include 'db.php';

$pilih_akses_jabatan_hapus = $db->query("SELECT jabatan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_hapus = '1'");
$jabatan_hapus = mysqli_num_rows($pilih_akses_jabatan_hapus);


    if ($jabatan_hapus > 0){
			echo "<th> Hapus </th>";
		}
?>

<?php 
include 'db.php';

$pilih_akses_jabatan_edit = $db->query("SELECT jabatan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_edit = '1'");
$jabatan_edit = mysqli_num_rows($pilih_akses_jabatan_edit);


    if ($jabatan_edit > 0){
    	echo "<th> Edit </th>";
    }
 ?>
			
			
		</thead>
		
		<tbody>
		<?php

		// menyimpan data sementara yang ada pada $query
			while ($data = mysqli_fetch_array($query))
			{
				//menampilkan data
			echo "<tr>
			
			<td>". $data['nama'] ."</td>
			<td>". $data['wewenang'] ."</td>";

include 'db.php';

$pilih_akses_jabatan_hapus = $db->query("SELECT jabatan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_hapus = '1'");
$jabatan_hapus = mysqli_num_rows($pilih_akses_jabatan_hapus);


    if ($jabatan_hapus > 0){

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-jabatan='". $data['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}

include 'db.php';

$pilih_akses_jabatan_edit = $db->query("SELECT jabatan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND jabatan_edit = '1'");
$jabatan_edit = mysqli_num_rows($pilih_akses_jabatan_edit);


    if ($jabatan_edit > 0){ 
			echo "<td> <button class='btn btn-info btn-edit' data-jabatan='". $data['nama'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
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
		var nama = $(this).attr("data-jabatan");
		var id = $(this).attr("data-id");
		$("#data_jabatan").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();
		$.post("hapusjabatan.php",{id:id},function(data){
		if (data != "") {
		$("#table_baru").load('tabel-jabatan.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-jabatan"); 
		var id  = $(this).attr("data-id");
		$("#jabatan_edit").val(nama);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#jabatan_edit").val();
		var id = $("#id_edit").val();

		$.post("update_jabatan.php",{id:id,nama:nama},function(data){
		if (data == 'sukses') {
		$(".alert").show('fast');
		$("#table_baru").load('tabel-jabatan.php');
		$("#modal_edit").modal('hide');
		
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