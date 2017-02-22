<?php include 'session_login.php';

include 'db.php';
$session_id = session_id();

$query = $db->query("SELECT * FROM suplier");

 ?>

<table id="tableuser" class="table table-bordered">
		<thead>
			
			<th style='background-color: #4CAF50; color: white'> Nama Suplier </th>
			<th style='background-color: #4CAF50; color: white'> Alamat </th>
			<th style='background-color: #4CAF50; color: white'> Nomor Telpon </th>
<?php
include 'db.php';

$pilih_akses_suplier_hapus = $db->query("SELECT suplier_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND suplier_hapus = '1'");
$suplier_hapus = mysqli_num_rows($pilih_akses_suplier_hapus);


    if ($suplier_hapus > 0){
			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";
		}
?>
<?php
include 'db.php';

$pilih_akses_suplier_edit = $db->query("SELECT suplier_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND suplier_edit = '1'");
$suplier_edit = mysqli_num_rows($pilih_akses_suplier_edit);


    if ($suplier_edit > 0){
			echo"<th style='background-color: #4CAF50; color: white'> Edit </th>";
		}
?>
			
		</thead>
		
		<tbody>
		<?php

		
			while ($data = mysqli_fetch_array($query))
			{
			echo "<tr>
			
			<td>". $data['nama'] ."</td>
			<td>". $data['alamat'] ."</td>
			<td>". $data['no_telp'] ."</td>";


include 'db.php';

$pilih_akses_suplier_hapus = $db->query("SELECT suplier_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND suplier_hapus = '1'");
$suplier_hapus = mysqli_num_rows($pilih_akses_suplier_hapus);


    if ($suplier_hapus > 0){
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-suplier='". $data['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
			}


include 'db.php';

$pilih_akses_suplier_edit = $db->query("SELECT suplier_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND suplier_edit = '1'");
$suplier_edit = mysqli_num_rows($pilih_akses_suplier_edit);


    if ($suplier_edit > 0){			
			echo "<td> <button class='btn btn-info btn-edit' data-suplier='". $data['nama'] ."' data-alamat='". $data['alamat'] ."' data-nomor='". $data['no_telp'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
		}

			echo "</tr>";
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

							<script type="text/javascript">	

							$(document).ready(function(){

						//fungsi hapus data 
								$(".btn-hapus").click(function(){
								var suplier = $(this).attr("data-suplier");
								var id = $(this).attr("data-id");
								$("#data_suplier").val(suplier);
								$("#id_hapus").val(id);
								$("#modal_hapus").modal('show');
								
								
								});
								
								
								$("#btn_jadi_hapus").click(function(){
								
								var id = $("#id_hapus").val();
								
								$.post("hapussuplier.php",{id:id},function(data){
								if (data == "sukses") {
								$("#table_baru").load('tabel-suplier.php');
								$("#modal_hapus").modal('hide');
								
								}
								
								
								});
								
								});
					// end fungsi hapus data

				    //fungsi edit data 
								$(".btn-edit").click(function(){
								
								$("#modal_edit").modal('show');
								var nama = $(this).attr("data-suplier");
								var alamat = $(this).attr("data-alamat");
								var no_telp = $(this).attr("data-nomor");
								var id   = $(this).attr("data-id");
								$("#edit_suplier").val(nama);
								$("#edit_alamat").val(alamat);
								$("#edit_nomor").val(no_telp);
								$("#id_edit").val(id);
								
								
								});
								
								$("#submit_edit").click(function(){
								var nama = $("#edit_suplier").val();
								var alamat = $("#edit_alamat").val();
								var no_telp = $("#edit_nomor").val();
								var id   = $("#id_edit").val();
								
								$.post("updatesuplier.php",{nama:nama,alamat:alamat,no_telp:no_telp,id:id},function(data){
								if (data == 'sukses') {
								$(".alert").show('fast');
								$("#table_baru").load('tabel-suplier.php');
								
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