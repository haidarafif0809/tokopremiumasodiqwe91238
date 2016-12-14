<?php include 'session_login.php';


include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

$perintah = $db->query("SELECT * FROM hak_otoritas");

 ?>

 <style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

 					
<div class="container">

<h3><b>DATA HAK OTORITAS</b></h3> <hr>
<!-- Trigger the modal with a button -->

<?php
include 'db.php';

$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_tambah = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#MyModal"> <i class="fa fa-plus"> </i> OTORITAS </button>';
}
?>
<br>
<br>

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Info Hak Akses </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- Modal tambah data -->
<div id="MyModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Data Otoritas</h4>
      </div>
    <div class="modal-body">
<form role="form">
					<div class="form-group">
					<label> Nama Otoritas </label><br>
					<input type="text" name="nama" id="nama_otoritas" class="form-control" autocomplete="off" required="" >
					</div>
								
					
					
					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>
</form>

				
					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>

 	</div><!-- end of modal body -->

					<div class ="modal-footer">
					<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
	</div>
	</div>

</div><!-- end of modal buat data  -->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Otoritas</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Otoritas :</label>
     <input type="text" id="data_otoritas" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->




<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Otoritas</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Otoritas:</label>
     <input type="text" class="form-control" id="otoritas_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
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


</div>
					

					</span>
</div>
</div> <!-- tag penutup cantainer -->

<script type="text/javascript">
	
  $(document).ready(function() {
  $(".table").dataTable({ordering :false });
  });

</script>

							
<script>
    $(document).ready(function(){


//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var nama = $("#nama_otoritas").val();

		if (nama == ""){
		alert("Nama Harus Diisi");
		}
		else {
		
		$.post('proses_otoritas.php',{nama:nama},function(data){

		if (data != '') {
		$("#nama_otoritas").val('');

		$(".alert").show('fast');
		$("#table_baru").load('tabel-otoritas.php');
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});										
									}

		
		
		});

// end fungsi tambah data


	
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama = $(this).attr("data-otoritas");
		var id = $(this).attr("data-id");
		$("#data_otoritas").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();

		$.post("hapus_otoritas.php",{id:id},function(data){

		if (data != "") {
		$("#table_baru").load('tabel-otoritas.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
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
		
		$("#submit_edit").click(function(){
		var nama = $("#otoritas_edit").val();
		var id = $("#id_edit").val();

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		else {

		$.post("update_otoritas.php",{id:id,nama:nama},function(data){
		if (data != '') {
		$(".alert").show('fast');
		$("#table_baru").load('tabel-otoritas.php');
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});
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

<script type="text/javascript">
	$("#nama_otoritas").keyup(function(){
		var nama_otoritas = $("#nama_otoritas").val();


		 $.post('cek_nama_otoritas.php',{nama:nama_otoritas}, function(data){
                
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
	$("#otoritas_edit").keyup(function(){
		var nama_otoritas = $("#otoritas_edit").val();


		 $.post('cek_nama_otoritas.php',{nama:nama_otoritas}, function(data){
                
                if(data == 1){

                    alert ("Otoritas Sudah Ada");
                    $("#otoritas_edit").val('');
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


<!-- memasukan file footer.db -->
<?php include 'footer.php'; ?>
