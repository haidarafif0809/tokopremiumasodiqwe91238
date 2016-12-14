<?php include 'session_login.php';

include 'db.php';
$session_id = session_id();

$query = $db->query("SELECT * FROM pemasukan");



 ?>

<table id="tableuser" class="table table-hover">
		<thead>
			<th style='background-color: #4CAF50; color: white'	> Nama  </th>

<?php 
include 'db.php';

$pilih_akses_pemasukan_hapus = $db->query("SELECT pemasukan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pemasukan_hapus = '1'");
$pemasukan_hapus = mysqli_num_rows($pilih_akses_pemasukan_hapus);

    if ($pemasukan_hapus > 0) {
			echo "<th style='background-color: #4CAF50; color: white'	> Hapus </th>";
		}
?>

<?php
include 'db.php';

$pilih_akses_pemasukan_edit = $db->query("SELECT pemasukan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pemasukan_edit = '1'");
$pemasukan_edit = mysqli_num_rows($pilih_akses_pemasukan_edit);

    if ($pemasukan_edit > 0) {
			echo "<th style='background-color: #4CAF50; color: white'	> Edit </th>";
		}
?>
			
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($query))
			{
			echo "<tr>
			<td>". $data['nama'] ."</td>";

include 'db.php';

$pilih_akses_pemasukan_hapus = $db->query("SELECT pemasukan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pemasukan_hapus = '1'");
$pemasukan_hapus = mysqli_num_rows($pilih_akses_pemasukan_hapus);

    if ($pemasukan_hapus > 0) {

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."'  data-pemasukan='". $data['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
			}
			

include 'db.php';

$pilih_akses_pemasukan_edit = $db->query("SELECT pemasukan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pemasukan_edit = '1'");
$pemasukan_edit = mysqli_num_rows($pilih_akses_pemasukan_edit);

    if ($pemasukan_edit > 0) {
			echo "<td> <button class='btn btn-info btn-edit' data-pemasukan='". $data['nama'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
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
    $('.table').DataTable();
});

</script>

						 <script>
                             
								$(document).ready(function(){

				
					//fungsi hapus data 
								$(".btn-hapus").click(function(){
								var nama = $(this).attr("data-pemasukan");
								var id = $(this).attr("data-id");
								$("#data_pemasukan").val(nama);
								$("#id_hapus").val(id);
								$("#modal_hapus").modal('show');
								
								
								});
								
								
								$("#btn_jadi_hapus").click(function(){
								
								var id = $("#id_hapus").val();
								
								$.post("hapus_pemasukan.php",{id:id},function(data){
								if (data != "") {
								$("#table_baru").load('tabel-pemasukan.php');
								$("#modal_hapus").modal('hide');
								
								}
								
								
								});
								
								});
					// end fungsi hapus data

				    //fungsi edit data 
								$(".btn-edit").click(function(){
								
								$("#modal_edit").modal('show');
								var nama = $(this).attr("data-pemasukan");
								var id   = $(this).attr("data-id");
								$("#edit_pemasukan").val(nama);
								$("#id_edit").val(id);
								
								
								});
								
								$("#submit_edit").click(function(){
								var nama = $("#edit_pemasukan").val();
								var id   = $("#id_edit").val();
								
								$.post("update_pemasukan.php",{nama:nama,id:id},function(data){
								if (data == 'sukses') {
								$(".alert").show('fast');
								$("#table_baru").load('tabel-pemasukan.php');
								
								setTimeout(tutupalert, 2000);
								$(".modal").modal("hide");
								}
								
								
								});
								function tutupmodal() {
								
								}	
								});
								
								
								
					 //end function edit data
								
								$('form').submit(function(){
								
								return false;
								});
								
								});
								
								
								
								
								function tutupalert() {
								$(".alert").hide("fast")
								}

			

        </script>
