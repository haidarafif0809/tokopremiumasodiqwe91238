<?php include 'session_login.php';

	
	
	include 'header.php';
	include 'navbar.php';
	include 'sanitasi.php';
	include 'db.php';

	$query = $db->query("SELECT * FROM kategori");
	
	?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container">
<!-- Modal tambah data -->


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Kategori Item </h4>
      </div>
      <div class="modal-body">
<form role="form">

					<div class="form-group">
					<label> Nama Kategori </label><br>
					<input type="text" name="nama_kategori" id="nama_kategori" class="form-control" autocomplete="off" required="" >
					</div>

   
   
   					<button type="Tambah" id="submit_tambah" class="btn btn-success"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>
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


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Kategori Item</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Kategori Item :</label>
     <input type="text" id="data_kategori" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span>Batal</button>
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
        <h4 class="modal-title">Edit Nama Kategori Item</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Kategori Item:</label>
     <input type="text" class="form-control" id="kategori_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-primary">Submit</button>
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

<h3><b>DATA KATEGORI</b></h3><hr>

<?php
include 'db.php';

$pilih_akses_otoritas = $db->query("SELECT kategori_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND kategori_tambah = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> KATEGORI</button>';

}
?>
<br><br>


<div class="table-responsive"><!-- membuat agar ada garis pada tabel, disetiap kolom -->
<span id="table_baru">
<table id="tableuser" class="table table-bordered">
		<thead> 
			
			<th style="background-color: #4CAF50; color: white"> Nama Kategori </th>
			<th style="background-color: #4CAF50; color: white"> Hapus </th>
			<th style="background-color: #4CAF50; color: white"> Edit </th>		
			
		</thead>
		
		<tbody>
		<?php

		// menyimpan data sementara yang ada pada $query
	while ($data = mysqli_fetch_array($query))
	{
				//menampilkan data
			echo "<tr>
			
			<td>". $data['nama_kategori'] ."</td>";


$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td><button class='btn btn-danger btn-hapus' data-id='". $data['id'] ."' data-kategori='". $data['nama_kategori'] ."'> <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td>";
}

$pilih_akses_otoritas = $db->query("SELECT hak_otoritas_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND hak_otoritas_edit = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo "<td> <button class='btn btn-info btn-edit' data-kategori='". $data['nama_kategori'] ."' data-id='". $data['id'] ."'> <span class='glyphicon glyphicon-edit'> </span> Edit </button> </td>";
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

</div>


<script type="text/javascript">
	
  $(function () {
  $(".table").dataTable({ordering :false });
  });

</script>


<script>
    $(document).ready(function(){


//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var nama = $("#nama_kategori").val();

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		
		else {
		
		$.post('proses_tambah_kategori.php',{nama:nama},function(data){

		if (data != '') {
		$("#nama_kategori").val('');

		$(".alert").show('fast');
		$("#table_baru").load('tabel-kategori.php');
		
		setTimeout(tutupalert, 2000);
		$(".modal").modal("hide");
		}
		
		
		});										
									}

		function tutupmodal() {
		
		}		
		
		});

// end fungsi tambah data


	
//fungsi hapus data 
		$(".btn-hapus").click(function(){
		var nama = $(this).attr("data-kategori");
		var id = $(this).attr("data-id");
		$("#data_kategori").val(nama);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $("#id_hapus").val();

		$.post("hapus_kategori.php",{id:id},function(data){

		if (data != "") {
		$("#table_baru").load('tabel-kategori.php');
		$("#modal_hapus").modal('hide');
		
		}

		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-kategori"); 
		var id  = $(this).attr("data-id");
		$("#kategori_edit").val(nama);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#kategori_edit").val();
		var id = $("#id_edit").val();

		if (nama == ""){
			alert("Nama Harus Diisi");
		}
		else {

					$.post("update_kategori.php",{id:id,nama:nama},function(data){
		if (data != '') {
		$(".alert").show('fast');
		$("#table_baru").load('tabel-kategori.php');
		
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
