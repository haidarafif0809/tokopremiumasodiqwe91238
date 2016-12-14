<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';


$query = $db->query("SELECT * FROM suplier");

 ?>


<div class="container">
<h3><b>DATA SUPLIER</b></h3> <hr>
<!-- Trigger the modal with a button -->

<?php  
include 'db.php';

$pilih_akses_suplier = $db->query("SELECT suplier_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND suplier_tambah = '1'");
$suplier = mysqli_num_rows($pilih_akses_suplier);


    if ($suplier > 0){
echo'<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"> </i> SUPLIER</button>';
}

?>
<br>
<br>



<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Data Suplier</h4>
      </div>
    <div class="modal-body">
<form role="form">
		<div class="form-group">
					
					<label> Nama Suplier </label><br>
					<input type="text" name="suplier" id="suplier" class="form-control" autocomplete="off" required="" ><br>
					

					<label> Alamat </label><br>
					<textarea name="alamat" id="alamat" class="form-control" ></textarea> <br>

					<label> No. Telp </label><br>
					<input type="text" name="nomor" id="nomor" class="form-control" autocomplete="off" required="" ><br>


					

					<button type="submit" id="submit_tambah" class="btn btn-success">Submit</button>

		</div>
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
        <h4 class="modal-title">Konfirmasi Hapus Data Suplier</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
		<label> Nama Suplier :</label>
		<input type="text" id="data_suplier" class="form-control" readonly=""> 
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
        <h4 class="modal-title">Edit Data Suplier</h4>
      </div>
      
  <form role="form">

  			<div class="modal-body">
					<label> Nama Suplier </label><br>
					<input type="text" name="edit_suplier" id="edit_suplier" class="form-control" autocomplete="off" required="" ><br>
					

					<label> Alamat </label><br>
					<textarea type="text" name="edit_alamat" id="edit_alamat" class="form-control" autocomplete="off" required="" > 
					</textarea><br>

					<label> No. Telp </label><br>
					<input type="text" name="edit_nomor" id="edit_nomor" class="form-control" autocomplete="off" required="" ><br>

    			    <input type="hidden" class="form-control" id="id_edit">
    
   
   
   
   					<button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
   			</div>			
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>
 

    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div><!-- end of modal edit data  -->


<style>

tr:nth-child(even){background-color: #f2f2f2}


</style>


<div class="table-responsive">
<span id="table_baru">
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
</span>
</div>



<script>

$(document).ready(function(){
    $('.table').DataTable();
});

</script>


        <script type="text/javascript">
                             
								$(document).ready(function(){

					//fungsi untuk menambahkan data
								$("#submit_tambah").click(function(){

								var suplier = $("#suplier").val();
								var alamat = $("#alamat").val();
								var nomor = $("#nomor").val();

								$("#suplier").val('');
								$("#alamat").val('');
								$("#nomor").val('');

								if (suplier == "") {
									alert("Nama Suplier harus Diisi");
								}
								else if (alamat == "") {
									alert("Alamat harus Diisi");
								}
								else if (nomor == "") {
									alert("Nomor Telpon harus Diisi");
								}
								else {
									$.post('prosessuplier.php', {nama:suplier,alamat:alamat,no_telp:nomor}, function(data){
								
								if (data != "") {
								$("#suplier").val('');
								$("#alamat").val('');
								$("#nomor").val('');
								
								$(".alert").show('fast');
								$("#table_baru").load('tabel-suplier.php');
								
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
								
								if (nama == ""){
									alert("Nama Harus Diisi");
								}
								else if (alamat == ""){
									alert("Alamat Harus Diisi");
								}
								else if (no_telp == ""){
									alert("Nomor Telpon Harus Diisi");
								}
								else {
								$.post("updatesuplier.php",{nama:nama,alamat:alamat,no_telp:no_telp,id:id},function(data){
								if (data == 'sukses') {
								$(".alert").show('fast');
								$("#table_baru").load('tabel-suplier.php');
								
								setTimeout(tutupalert, 2000);
								$(".modal").modal("hide");
								}
								
								
								});
																	
								}


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
