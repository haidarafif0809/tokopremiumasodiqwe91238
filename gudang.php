<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$query = $db->query("SELECT * FROM gudang");



 ?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container">

<h3><b>DATA GUDANG</b></h3> <hr>
<?php

include 'db.php';

$pilih_akses_otoritas = $db->query("SELECT gudang_tambah FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND gudang_tambah = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo '<button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> </i> GUDANG</button>';

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
        <h4 class="modal-title">Tambah Data Gudang</h4>
      </div>
      <div class="modal-body">
<form role="form">
					

					<div class="form-group">
					<label> Kode Gudang </label><br>
					<input type="text" name="kode_gudang" id="kode_gudang" class="form-control" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Nama Gudang </label>
					<br>
					<input type="text" id="nama_gudang" name="nama_gudang" class="form-control" required="" autocomplete="off">

					</div>

   					<button type="submit" id="submit_tambah" class="btn btn-success"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>
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
        <h4 class="modal-title">Konfirmasi Hapus Data Gudang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Gudang :</label>
     <input type="text" id="data_gudang" class="form-control" readonly=""> 
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
        <h4 class="modal-title">Edit Data Gudang</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    <label for="email">Nama Gudang:</label>
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



<div class="table-responsive">
<span id="table-baru">
<table id="table_gudang" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color: white"> Kode Gudang </th>
			<th style="background-color: #4CAF50; color: white"> Nama Gudang </th>

<?php
$pilih_akses_otoritas = $db->query("SELECT gudang_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]' AND gudang_hapus = '1'");
$otoritas = mysqli_num_rows($pilih_akses_otoritas);

    if ($otoritas > 0) {
echo '<th style="background-color: #4CAF50; color: white"> Hapus </th>';
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
		var kode_gudang = $("#kode_gudang").val();
		var nama_gudang = $("#nama_gudang").val();

		$("#kode_gudang").val('');
		$("#nama_gudang").val('');

		if (kode_gudang == ""){
			alert("Kode Gudang Harus Diisi");
		}
		else if (nama_gudang == ""){
			alert("Nama Gudang Harus Diisi");
		}
		else{

		$.post('proses_tambah_gudang.php',{kode_gudang:kode_gudang,nama_gudang:nama_gudang},function(data){

		if (data != '') {
		$("#kode_gudang").val('');
		$("#nama_gudang").val('');
		$("#myModal").modal("hide");
		$('#table_gudang').DataTable().destroy();
		var dataTable = $('#table_gudang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_gudang.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_gudang").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[3]+'');
            },
        });

		}
		
		
		});
		}
		
		
		function tutupmodal() {
		
		}
		});

		});

// end fungsi tambah data
</script>

<script>
	    $(document).ready(function(){
		  $(document).on('click', '.btn-hapus', function (e) {

		var id = $(this).attr("data-id");

		$.post("hapus_gudang.php",{id:id},function(data){

		

		$('#table_gudang').DataTable().destroy();
		var dataTable = $('#table_gudang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_gudang.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_gudang").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[3]+'');
            },
        });
		
		});
		
		});

		$('form').submit(function(){
		
		return false;
		});

	});
		


</script>

                             <script type="text/javascript">
                                 
                                 $(document).on('dblclick', '.edit-nama', function (e) {

                                    var id = $(this).attr("data-id");

                                    $("#text-nama-"+id+"").hide();

                                    $("#input-nama-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input_nama', function (e) {

                                    var id = $(this).attr("data-id");

                                    var input_nama = $(this).val();


                                     $.post("update_gudang.php",{id:id, input_nama:input_nama ,jenis_nama:"nama_gudang"},function(data){

                                    $("#text-nama-"+id+"").show();
                                    $("#text-nama-"+id+"").text(input_nama);

                                    $("#input-nama-"+id+"").attr("type", "hidden");           

                                    });
                                 });

                             </script>

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_gudang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_gudang.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_gudang").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[3]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>


<?php include 'footer.php'; ?>

