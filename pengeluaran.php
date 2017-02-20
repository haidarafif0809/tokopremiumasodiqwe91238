<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';


$query = $db->query("SELECT * FROM pengeluaran");



 ?>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>




<div class="container">
<h3><b><u> Data Pengeluaran </u></b></h3> <br>
<!-- Trigger the modal with a button -->

<?php
include 'db.php';

$pilih_akses_pengeluaran = $db->query("SELECT pengeluaran_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pengeluaran_tambah = '1'");
$pengeluaran = mysqli_num_rows($pilih_akses_pengeluaran);

    if ($pengeluaran > 0) {
echo '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"> <span class="glyphicon glyphicon-plus"> </span> Tambah Pengeluaran</button>';
}

?>
<br>
<br>



<!-- Modal Tambah Data -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Pengeluaran</h4>
     	 </div>
   <div class="modal-body">
        
<!--form--><form role="form">
					

					<div class="form-group">
					<label> Nama </label><br>
					<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required="" >
					<br>


					
					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>
					</div>
			</form>

					<div class="alert alert-success" style="display:none">
					<strong>Berhasil!</strong> Data berhasil Di Tambah
					</div>
	</div> <!--div body-->


     <!--button penutup-->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>


    </div>

  </div>
</div>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Pengeluaran</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
		<label> Nama Pengeluaran :</label>
		<input type="text" id="data_pengeluaran" class="form-control" readonly=""> 
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
        <h4 class="modal-title">Edit Data Pengeluaran</h4>
      </div>
      
  <form role="form">
  			<div class="modal-body">
					<label> Nama Pengeluaran </label><br>
					<input type="text" name="edit_pengeluaran" id="edit_pengeluaran" class="form-control" autocomplete="off" required="" ><br>
					

    			    <input type="hidden" class="form-control" id="id_edit">
    
   
   					<button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
   			</div>			
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

    
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->

<div class="table-responsive">
<span id="table_baru">
<table id="tableuser" class="table table-hover">
		<thead>
			<th style="background-color: #4CAF50; color: white"> Nama  </th>

<?php
include 'db.php';

$pilih_akses_pengeluaran_hapus = $db->query("SELECT pengeluaran_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pengeluaran_hapus = '1'");
$pengeluaran_hapus = mysqli_num_rows($pilih_akses_pengeluaran_hapus);

    if ($pengeluaran_hapus > 0) {
			echo "<th style='background-color: #4CAF50; color: white'> Hapus </th>";
		}
?>

<?php 
include 'db.php';

$pilih_akses_pengeluaran_edit = $db->query("SELECT pengeluaran_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pengeluaran_edit = '1'");
$pengeluaran_edit = mysqli_num_rows($pilih_akses_pengeluaran_edit);

    if ($pengeluaran_edit > 0) {
		echo "<th style='background-color: #4CAF50; color: white'> Edit </th>";

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

$pilih_akses_pengeluaran_hapus = $db->query("SELECT pengeluaran_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pengeluaran_hapus = '1'");
$pengeluaran_hapus = mysqli_num_rows($pilih_akses_pengeluaran_hapus);

    if ($pengeluaran_hapus > 0) {

			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."'  data-pengeluaran='". $data['nama'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
		}


include 'db.php';

$pilih_akses_pengeluaran_edit = $db->query("SELECT pengeluaran_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pengeluaran_edit = '1'");
$pengeluaran_edit = mysqli_num_rows($pilih_akses_pengeluaran_edit);

    if ($pengeluaran_edit > 0) {
			echo "<td> <button class='btn btn-info btn-edit' data-pengeluaran='". $data['nama'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>
			</tr>";
		}
			}

			//Untuk Memutuskan Koneksi Ke Database
			mysqli_close($db);   
		?>
		</tbody>

	</table>
	</span>
</div>
</div>


<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>


								
							<script>
								
								$(document).ready(function(){
								
						//fungsi untuk menambahkan data
								$("#submit_tambah").click(function(){
								
								var pengeluaran = $("#nama").val();
								$("#nama").val('');
								
								if (pengeluaran == "") {
									alert("Kolom Pengeluaran Harus Diisi");
								}
								else{
								$.post('proses_pengeluaran.php', {nama:pengeluaran}, function(data){
								
								if (data != "") {
								$("#nama").val('');
								
								$(".alert").show('fast');
								$("#table_baru").load('tabel-pengeluaran.php');
								
								setTimeout(tutupalert, 2000);
								$(".modal").modal("hide");
								}
								
								
								});									
								}

								
								function tutupmodal() {
								
								}		
								
								});
								
						// end fungsi tambah 
								
						//fungsi hapus data 
								$(".btn-hapus").click(function(){
								var nama = $(this).attr("data-pengeluaran");
								var id = $(this).attr("data-id");
								$("#data_pengeluaran").val(nama);
								$("#id_hapus").val(id);
								$("#modal_hapus").modal('show');
								
								
								});
								
								
								$("#btn_jadi_hapus").click(function(){
								
								var id = $("#id_hapus").val();
								
								$.post("hapus_pengeluaran.php",{id:id},function(data){
								if (data != "") {
								$("#table_baru").load('tabel-pengeluaran.php');
								$("#modal_hapus").modal('hide');
								
								}
								
								
								});
								
								});
						// end fungsi hapus data
								
					//fungsi edit data 
								$(".btn-edit").click(function(){
								
								$("#modal_edit").modal('show');
								var pengeluaran = $(this).attr("data-pengeluaran");
								var id   = $(this).attr("data-id");
								$("#edit_pengeluaran").val(pengeluaran);
								$("#id_edit").val(id);
								
								
								});
								
								$("#submit_edit").click(function(){
								var nama = $("#edit_pengeluaran").val();
								var id   = $("#id_edit").val();
								
								$.post("update_pengeluaran.php",{nama:nama,id:id},function(data){
								if (data != "") {
								$(".alert").show('fast');
								$("#table_baru").load('tabel-pengeluaran.php');
								
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

<?php include 'footer.php'; ?>

