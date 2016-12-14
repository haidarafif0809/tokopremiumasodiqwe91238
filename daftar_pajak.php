<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$query = $db->query("SELECT * FROM daftar_pajak");



 ?>



<div class="container">

<h3><b>DATA DAFTAR PAJAK</b></h3> <hr>

<?php 
include 'db.php';

$pilih_akses_daftar_pajak_tambah = $db->query("SELECT daftar_pajak_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_pajak_tambah = '1'");
$daftar_pajak_tambah = mysqli_num_rows($pilih_akses_daftar_pajak_tambah);


    if ($daftar_pajak_tambah > 0){
// Trigger the modal with a button -->
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> DAFTAR PAJAK</button>';

}

?>
<br>
<br>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Daftar Pajak</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Pajak :</label>
     <input type="text" id="data_pajak" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!-- Modal tambah data -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Daftar Pajak</h4>
      </div>
      <div class="modal-body">
<form role="form">
   <div class="form-group">
					

					<div class="form-group">
					<label> Nama Pajak </label><br>
					<input type="text" name="nama_pajak" id="nama_pajak" class="form-control" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Deskripsi </label><br>
					<input type="text" id="deskripsi" name="deskripsi" class="form-control" autocomplete="off" required="">

					</div>


					<div class="form-group">
					<label> Nilai Pajak (%) </label><br>
					<input type="text" name="nilai_persen" id="nilai_persen" class="form-control" autocomplete="off" required="" >
					</div>


					<div class="form-group">
					<label> Jenis Pajak </label><br>
					<select name="jenis_pajak" id="jenis_pajak" class="form-control">
						<option>Include</option>
						<option>Exclude</option>
					</select>
					</div>

     
   </div>
   
   
   					<button type="submit" id="submit_tambah" class="btn btn-primary"><i class='fa fa-plus'> </i> Tambah</button>
</form>
				
				<div class="alert alert-success" style="display:none">
				<strong>Berhasil!</strong> Data berhasil Di Tambah
				</div>
  </div>
				<div class ="modal-footer">
				<button type ="button"  class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
  </div>

  </div>
</div><!-- end of modal buat data  -->

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Daftar Pajak</h4>
      </div>
      <div class="modal-body">
<form role="form">
   <div class="form-group">
					

					<div class="form-group">
					<label> Nama Pajak </label><br>
					<input type="text" name="nama_pajak" id="edit_nama_pajak" class="form-control" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Deskripsi </label><br>
					<input type="text" id="edit_deskripsi" name="deskripsi" class="form-control" autocomplete="off" required="">	

					</div>


					<div class="form-group">
					<label> Nilai Pajak (%) </label><br>
					<input type="text" id="edit_nilai_persen" name="nilai_pajak" class="form-control" autocomplete="off" required="" >
					</div>


					<div class="form-group">
					<label> Jenis Pajak </label><br>
					<select name="jenis_pajak" id="edit_jenis_pajak" class="form-control">
						<option>Include</option>
						<option>Exclude</option>
					</select>
					</div>

     
   </div>	
   					<input type="hidden" class="form-control" id="id_edit">
   
   
   					<button type="submit" id="submit_edit" class="btn btn-primary"><i class='fa fa-save'> </i> Simpan</button>
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

<style>
table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="table-responsive">
<span id="table-baru">
<table id="tableuser" class="table table-bordered">
		<thead>
			<th> Nama Pajak </th>
			<th> Deskripsi </th>
			<th> Nilai Persen </th>
			<th> Jenis Pajak </th>

<?php 
include 'db.php';

$pilih_akses_daftar_pajak_hapus = $db->query("SELECT daftar_pajak_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_pajak_hapus = '1'");
$daftar_pajak_hapus = mysqli_num_rows($pilih_akses_daftar_pajak_hapus);


    if ($daftar_pajak_hapus > 0){
			echo "<th> Hapus </th>";

		}


$pilih_akses_daftar_pajak_edit = $db->query("SELECT daftar_pajak_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_pajak_edit = '1'");
$daftar_pajak_edit = mysqli_num_rows($pilih_akses_daftar_pajak_edit);


    if ($daftar_pajak_edit > 0){
			echo "<th> Edit </th>";

		}
?>

			
		</thead>
		
		<tbody id="tbody">
			<?php
			
			
			while ($data = mysqli_fetch_array($query))
			{
			echo "<tr class='tr-id-".$data['id']."'>
			<td>". $data['nama_pajak'] ."</td>
			<td>". $data['deskripsi'] ."</td>
			<td>". $data['persen_pajak'] ."</td>
			<td>". $data['jenis_pajak'] ."</td>";
			
			
			include 'db.php';
			
			$pilih_akses_daftar_pajak_hapus = $db->query("SELECT daftar_pajak_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_pajak_hapus = '1'");
			$daftar_pajak_hapus = mysqli_num_rows($pilih_akses_daftar_pajak_hapus);
			
			
			if ($daftar_pajak_hapus > 0){
			echo "<td> <button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-daftar-pajak='". $data['nama_pajak'] ."'> <i class='fa fa-trash'> </i> Hapus </button> </td>";

			}

			$pilih_akses_daftar_pajak_edit = $db->query("SELECT daftar_pajak_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND daftar_pajak_edit = '1'");
			$daftar_pajak_edit = mysqli_num_rows($pilih_akses_daftar_pajak_edit);
			
			
			if ($daftar_pajak_edit > 0){
			echo "<td> <button class='btn btn-secondary btn-edit' data-id='". $data['id'] ."' data-daftar-pajak='". $data['nama_pajak'] ."' data-deskripsi='". $data['deskripsi'] ."' data-persen-pajak='". $data['persen_pajak'] ."' data-jenis-pajak='". $data['jenis_pajak'] ."'> <i class='fa fa-edit'> </i> Edit </button> </td>";
			
			}

			echo "</tr>";
			}
			?>
		</tbody>

	</table>
</span>
</div>
</div>


					
<script type="text/javascript">

$("#nilai_persen").keyup(function(){
	var nilai_pajak = $("#nilai_persen").val();

		if (nilai_pajak > 100){
			alert("Nilai Pajak Tidak Boleh Lebih dari 100%");
			$("#nilai_persen").val('');
			$("#nilai_persen").focus();
		}

});

$("#edit_nilai_persen").keyup(function(){
	var nilai_pajak = $("#edit_nilai_persen").val();

		if (nilai_pajak > 100){
			alert("Nilai Pajak Tidak Boleh Lebih dari 100%");
			$("#edit_nilai_persen").val('');
			$("#edit_nilai_persen").focus();
		}

});


</script>		 


<script>
    $(document).ready(function(){


//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var nama_pajak = $("#nama_pajak").val();
		var deskripsi = $("#deskripsi").val();
		var nilai_pajak = $("#nilai_persen").val();
		var jenis_pajak = $("#jenis_pajak").val();



		if (nama_pajak == ""){
			alert("Nama Harus Diisi");
		}
		else if (deskripsi == ""){
			alert("Kolom Deskripsi Harus Diisi");
		}
		else if (nilai_pajak == ""){
			alert("Nilai Pajak Harus Diisi");
		}
		else if (jenis_pajak == ""){
			alert("Jenis Pajak Harus Diisi");
		}
		else{

 $.post("proses_daftar_pajak.php",{nama_pajak:nama_pajak,deskripsi:deskripsi,nilai_pajak:nilai_pajak,jenis_pajak:jenis_pajak},function(data){

		$("#tbody").prepend(data);
		$("#nama_pajak").val('');
		$("#deskripsi").val('');
		$("#nilai_persen").val('');
		$("#jenis_pajak").val('');

		$("#myModal").modal("hide");

		
		
		});
		}
		
		});
		});
// end fungsi tambah data

</script>

<script>
	
$(document).on('click', '.btn-hapus', function (e) {
		var nama_pajak = $(this).attr("data-daftar-pajak");
		var id = $(this).attr("data-id");

		$("#data_pajak").val(nama_pajak);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});


$(document).on('click', '#btn_jadi_hapus', function (e) {
		
		var id = $(this).attr("data-id");

		$.post("hapus_daftar_pajak.php",{id:id},function(data){
		if (data != "") {
		
		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id+"").remove();
		
		}

		
		});
		
		});

				    //fungsi edit data 
							  $(document).on('click', '.btn-edit', function (e) {
								
								$("#modal_edit").modal('show');
								var nama_pajak = $(this).attr("data-daftar-pajak");
								var deskripsi = $(this).attr("data-deskripsi");
								var nilai_pajak = $(this).attr("data-persen-pajak");
								var jenis_pajak   = $(this).attr("data-jenis-pajak");
								var id   = $(this).attr("data-id");
								$("#edit_nama_pajak").val(nama_pajak);
								$("#edit_deskripsi").val(deskripsi);
								$("#edit_nilai_persen").val(nilai_pajak);
								$("#edit_jenis_pajak").val(jenis_pajak);
								$("#id_edit").val(id);
								
								
								});
								
								$("#submit_edit").click(function(){
								var nama_pajak = $("#edit_nama_pajak").val();
								var deskripsi = $("#edit_deskripsi").val();
								var nilai_pajak = $("#edit_nilai_persen").val();
								var jenis_pajak = $("#edit_jenis_pajak").val();
								var id   = $("#id_edit").val();

								if (nama_pajak == ""){
									alert("Nama Harus Diisi");
								}
								else if (deskripsi == ""){
									alert("Kolom Deskripsi Harus Diisi");
								}
								else if (nilai_pajak == ""){
									alert("Nilai Pajak Harus Diisi");
								}
								else if (jenis_pajak == ""){
									alert("Jenis Pajak Harus Diisi");
								}
								else {

								$(".tr-id-"+id+"").remove();

								$.post("update_daftar_pajak.php",{nama_pajak:nama_pajak,deskripsi:deskripsi,nilai_pajak:nilai_pajak,jenis_pajak:jenis_pajak,id:id},function(data){

								

								$("#tbody").prepend(data);
								$("#modal_edit").modal('hide');
								
								
								
								});
								

								}


								});
								
								
								
					 //end function edit data

		$('form').submit(function(){
		
		return false;
		});
		

		
		function tutupalert() {
		$(".alert").hide("fast");

		}
		


</script>

<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>


<?php include 'footer.php'; ?>

