<?php session_start();

include 'sanitasi.php';
include 'db.php';
$session_id = session_id();

$perintah = $db->query("SELECT * FROM hak_otoritas");

 ?>

		<table id="tableuser" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color: white'> ID Otoritas </th>

<?php
include 'db.php';

$pilih_akses_otoritas_lihat = $db->query("SELECT hak_otoritas_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_lihat = '1'");
$otoritas_lihat = mysqli_num_rows($pilih_akses_otoritas_lihat);

    if ($otoritas_lihat > 0) {
			echo "<th style='background-color: #4CAF50; color: white'> Hak Akses </th>";
		}
	?>

<?php
include 'db.php';

$pilih_akses_otoritas_hapus = $db->query("SELECT hak_otoritas_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_hapus = '1'");
$otoritas_hapus = mysqli_num_rows($pilih_akses_otoritas_hapus);

    if ($otoritas_hapus > 0) {
			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";
		}
	?>

<?php
include 'db.php';

$pilih_akses_otoritas_edit = $db->query("SELECT hak_otoritas_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_edit = '1'");
$otoritas_edit = mysqli_num_rows($pilih_akses_otoritas_edit);

    if ($otoritas_edit > 0) {
			echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";
		}
	?>
			
			
		</thead>
		
		<tbody>
		<?php

			
			while ($data1 = mysqli_fetch_array($perintah))
			{
			echo "<tr>
			<td>". $data1['nama'] ."</td>";


include 'db.php';
$pilih_akses_otoritas_lihat = $db->query("SELECT hak_otoritas_lihat FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_lihat = '1'");
$otoritas_lihat = mysqli_num_rows($pilih_akses_otoritas_lihat);

    if ($otoritas_lihat > 0) {		

			echo "<td> <a href='form_hak_akses.php?nama=".$data1['nama']."&id=".$data1['id']."' class='btn btn-primary'> <span class='	glyphicon glyphicon-new-window'> </span> Hak Akses </a> </td>";
		}


include 'db.php';

$pilih_akses_otoritas_hapus = $db->query("SELECT hak_otoritas_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_hapus = '1'");
$otoritas_hapus = mysqli_num_rows($pilih_akses_otoritas_hapus);

    if ($otoritas_hapus > 0) {
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data1['id'] ."' data-otoritas='". $data1['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> ";
	}

include 'db.php';

$pilih_akses_otoritas_edit = $db->query("SELECT hak_otoritas_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_edit = '1'");
$otoritas_edit = mysqli_num_rows($pilih_akses_otoritas_edit);

    if ($otoritas_edit > 0) {
			echo "<td> <button class='btn btn-success btn-edit' data-otoritas='". $data1['nama'] ."' data-id='". $data1['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>

			</tr>";
			}
		}


		//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
		?>
		</tbody>

	</table>

<script type="text/javascript">
	
	$(document).ready(function(){
    $('.table').DataTable();
});


</script>

<script>
    $(document).ready(function(){


//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama = $(this).attr("data-otoritas");
		var id = $(this).attr("data-id");
		$("#data_otoritas").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


// end fungsi hapus data

//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-otoritas"); 
		var id  = $(this).attr("data-id");
		$("#otoritas_edit").val(nama);
		$("#id_edit").val(id);
		
		
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

<script type="text/javascript">
	$("#nama_otoritas").keyup(function(){
		var nama_otoritas = $("#nama_otoritas").val();


		 $.post('cek_nama_otoritas.php',{nama_otoritas:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Otoritas Sudah Ada");
                    $("#nama_otoritas").val('');
                }
                else {
                    
                }

	});
		});

</script>

		<script type="text/javascript">
		
		$(".btn-akses").click(function(){
		var nama = $(this).attr('data-otoritas');
		
		
		$("#modal_detail").modal('show');
		
		$.post('info_hak_akses.php',{nama:nama},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>