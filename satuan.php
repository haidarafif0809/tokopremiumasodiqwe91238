<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>



<div class="container">

<h3><b>DATA SATUAN</b></h3> <hr>

<?php 
$pilih_akses_satuan_tambah = $db->query("SELECT satuan_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_tambah = '1'");
$satuan_tambah = mysqli_num_rows($pilih_akses_satuan_tambah);


    if ($satuan_tambah > 0){
// Trigger the modal with a button -->
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> SATUAN</button>';

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
        <h4 class="modal-title">Tambah Data Satuan</h4>
      </div>
      <div class="modal-body">
<form role="form">
   <div class="form-group">
					

					<div class="form-group">
					<label> Satuan </label><br>
					<input type="text" name="nama" id="nama_satuan" class="form-control" autocomplete="off" required="" >
					</div>

     
   </div>
   
   
   					<button type="submit" id="submit_tambah" class="btn btn-primary"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>
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
        <h4 class="modal-title">Konfirmasi Hapus Data Satuan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Satuan :</label>
     <input type="text" id="data_satuan" class="form-control" readonly=""> 
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
        <h4 class="modal-title">Edit Data Satuan</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Satuan:</label>
     <input type="text" class="form-control" id="nama_edit" autocomplete="off">
     <input type="hidden" class="form-control" id="id_edit">
    
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-default">Submit</button>
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
<table id="table_satuan" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Satuan </th>


<?php 
$pilih_akses_satuan_hapus = $db->query("SELECT satuan_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_hapus = '1'");
$satuan_hapus = mysqli_num_rows($pilih_akses_satuan_hapus);


    if ($satuan_hapus > 0){
			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";

		}
?>

<?php
$pilih_akses_satuan_edit = $db->query("SELECT satuan_edit FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND satuan_edit = '1'");
$satuan_edit = mysqli_num_rows($pilih_akses_satuan_edit);


    if ($satuan_edit > 0){
			echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
		}
?>
			
		</thead>
	</table>
</span>
</div>
</div>


							 


<script>
    $(document).ready(function(){


//fungsi untuk menambahkan data
		$("#submit_tambah").click(function(){
		var nama = $("#nama_satuan").val();


		$("#nama_satuan").val('');


		if (nama == ""){
			alert("Nama Harus Diisi");
		}
	
		else{

		$.post('prosessatuan.php',{nama:nama},function(data){

		if (data != '') {
		$("#nama_satuan").val('');
		$(".alert").show('fast');
		$("#table-baru").load('tabel-satuan.php');
		
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
$(document).on('click', '.btn-hapus', function (e) {
		var nama_satuan = $(this).attr("data-satuan");
		var id = $(this).attr("data-id");
		$("#data_satuan").val(nama_satuan);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		
		
		});


$(document).on('click', '#btn_jadi_hapus', function (e) {
		
		var id = $("#id_hapus").val();
		$.post("hapussatuan.php",{id:id},function(data){
		if (data != "") {
		
		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id+"").remove();
		
		}

		
		});
		
		});
// end fungsi hapus data

//fungsi edit data 
		$(document).on('click', '.btn-edit', function (e) {
		
		$("#modal_edit").modal('show');
		var nama = $(this).attr("data-satuan"); 
		var id  = $(this).attr("data-id");
		$("#nama_edit").val(nama);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var nama = $("#nama_edit").val();
		var id = $("#id_edit").val();

		$.post("updatesatuan.php",{id:id,nama:nama},function(data){
		if (data == 'sukses') {
		$(".alert").show('fast');
		$("#table-baru").load('tabel-satuan.php');
		setTimeout(tutupmodal, 2000);
		setTimeout(tutupalert, 2000);
		
		}
		});
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});
		
		});
		
		
		
		
		function tutupalert() {
		$(".alert").hide("fast");

		}
		


</script>


<script type="text/javascript">
// AJAX TABLE AWAL TAMPIL
	$(document).ready(function(){
			$('#table_satuan').DataTable().destroy();
			
          var dataTable = $('#table_satuan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_satuan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_satuan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[3]+'');
            },

        });

        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>
<?php include 'footer.php'; ?>

