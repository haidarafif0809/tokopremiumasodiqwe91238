<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'db.php';


$query = $db->query("SELECT * FROM pemasukan");



 ?>

<style>


tr:nth-child(even){background-color: #f2f2f2}


</style>


<div class="container">
<h3><b><u> Data Pemasukan </u></b></h3> <br>
<!-- Trigger the modal with a button -->
<?php 

include 'db.php';

$pilih_akses_pemasukan = $db->query("SELECT pemasukan_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pemasukan_tambah = '1'");
$pemasukan = mysqli_num_rows($pilih_akses_pemasukan);


    if ($pemasukan > 0) {

echo '<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"> <span class="glyphicon glyphicon-plus"> </span> Tambah Pemasukan</button>';
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
        <h4 class="modal-title">Tambah Data Pemasukan</h4>
      </div>
    <div class="modal-body">
<form role="form">
		<div class="form-group">
					
					<label> Nama Pemasukan </label><br>
					<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required="">
					<br>
					

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
        <h4 class="modal-title">Konfirmasi Hapus Data Pemasukan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
		<label> Nama Pemasukan :</label>
		<input type="text" id="data_pemasukan" class="form-control" readonly=""> 
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
        <h4 class="modal-title">Edit Data Pemasukan</h4>
      </div>
      
  <form role="form">
  			<div class="modal-body">
					<label> Nama Pemasukan </label><br>
					<input type="text" name="edit_pemasukan" id="edit_pemasukan" class="form-control" autocomplete="off" required="" ><br>
					

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



<div class="table-responsive">
<span id="table_baru">
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

								var pemasukan = $("#nama").val();
								$("#nama").val('');


								if (pemasukan == "") {
									alert("Kolom Pemasukan Harus Diisi");
								}
								else{

								$.post('proses_pemasukan.php', {nama:pemasukan}, function(data){
								
								if (data != "") {
								$("#nama").val('');
								
								$(".alert").show('fast');
								$("#table_baru").load('tabel-pemasukan.php');
								
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
								var pemasukan = $(this).attr("data-pemasukan");
								var id   = $(this).attr("data-id");
								$("#edit_pemasukan").val(pemasukan);
								$("#id_edit").val(id);
								
								
								});
								
								$("#submit_edit").click(function(){
								var nama = $("#edit_pemasukan").val();
								var id   = $("#id_edit").val();
								
								if (nama == "") {
									alert("Kolom Pemasukan Harus Diisi");
								}
								else{

								$.post("update_pemasukan.php",{nama:nama,id:id},function(data){
								if (data == 'sukses') {
								$(".alert").show('fast');
								$("#table_baru").load('tabel-pemasukan.php');
								
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

