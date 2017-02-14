<?php include 'session_login.php';

	//memasukkan file session login, header, navbar, db.php
	include 'header.php';
	include 'navbar.php';
	include 'sanitasi.php';
	include 'db.php';

	?>

	<!-- js untuk tombol shortcut -->
	 <script src="shortcut.js"></script>
	<!-- js untuk tombol shortcut -->

	<style>
		tr:nth-child(even){background-color: #f2f2f2}
	</style>


	 <div class="container">

	 <h3><b> DATA PARCEL</b></h3><hr>
	<div class="row">
	<button class="btn btn-primary" id="btnParcel" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-shopping-basket" id="tambah_parcel"> </i>
	PARCEL (F1) </button>


	<!--MODAL EDIT -->
	<div id="modal_edit" class="modal fade" role="dialog">
	  <div class="modal-dialog">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">EDIT DATA PARCEL</h4>
	      </div>
	      <div class="modal-body">

	<form class="form" role="form" id="formparceledit">
			
			<div class="row">
			<div class="col-sm-6">	

			  
			  	<label>Nama Parcel</label>
			    <input style="height:15px;" type="text" class="form-control" name="nama_parcel" autocomplete="off" id="nama_parcel_edit" placeholder="NAMA PARCEL">

			  
			  	<label>Harga 1</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_1" autocomplete="off" id="harga_parcel_edit_1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 1">

			  
			  	<label>Harga 2</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_2" autocomplete="off" id="harga_parcel_edit_2" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 2">

			  
			  	<label>Harga 3</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_3" autocomplete="off" id="harga_parcel_edit_3" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 3">

			</div>
			

			<div class="col-sm-6">

			  
			  	<label>Harga 4</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_4" autocomplete="off" id="harga_parcel_edit_4" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 4">

			  
			  	<label>Harga 5</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_5" autocomplete="off" id="harga_parcel_edit_5" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 5">

			  
			  	<label>Harga 6</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_6" autocomplete="off" id="harga_parcel_edit_6" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 6">

			  
			  	<label>Harga 7</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_7" autocomplete="off" id="harga_parcel_edit_7" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 7">


			  <input style="height:15px;" type="hidden" class="form-control" name="id_edit" autocomplete="off" id="id_edit" placeholder="LEVEL 7">

			</div>
			</div>

			  	  <button type="submit" id="simpan_parcel" class="btn btn-success" style="font-size:15px"> <i class="fa fa-plus"> </i> Simpan (F3)</button>
			 
			
			
		</form> <!-- END FORM -->

	  <div class="alert alert-success" style="display:none">
	   <strong>Berhasil!</strong> Data Berhasil Di Edit
	  </div>
	 

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" id="close_edit" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </div>
	</div>
	<!-- END MODAL EDIT  -->


	<div class="collapse" id="collapseExample">

		<form class="form" role="form" id="formparcel">
			<div class=" card card-block">
			<div class="row">
			  <div class="col-sm-2">
			  	<label>Kode Parcel</label>
			    <input type="text" style="height:15px" class="form-control" name="kode_parcel" autocomplete="off" id="kode_parcel" placeholder="KODE PARCEL">
			  </div>

			  <div class="col-sm-2">
			  	<label>Nama Parcel</label>
			    <input style="height:15px;" type="text" class="form-control" name="nama_parcel" autocomplete="off" id="nama_parcel" placeholder="NAMA PARCEL">
			  </div>

			  <div class="col-sm-2">
			  	<label>Harga 1</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_1" autocomplete="off" id="harga_parcel_1" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 1">
			  </div>

			  <div class="col-sm-2">
			  	<label>Harga 2</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_2" autocomplete="off" id="harga_parcel_2" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 2">
			  </div>

			  <div class="col-sm-2">
			  	<label>Harga 3</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_3" autocomplete="off" id="harga_parcel_3" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 3">
			  </div>

			</div>

			<div class="row">

			  <div class="col-sm-2">
			  	<label>Harga 4</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_4" autocomplete="off" id="harga_parcel_4" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 4">
			  </div>

			  <div class="col-sm-2">
			  	<label>Harga 5</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_5" autocomplete="off" id="harga_parcel_5" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 5">
			  </div>

			  <div class="col-sm-2">
			  	<label>Harga 6</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_6" autocomplete="off" id="harga_parcel_6" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 6">
			  </div>

			  <div class="col-sm-2">
			  	<label>Harga 7</label>
			    <input style="height:15px;" type="text" class="form-control" name="harga_parcel_7" autocomplete="off" id="harga_parcel_7" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="LEVEL 7">
			  </div>


			  <div class="col-sm-2">
			  <label><br><br><br></label>
			  	  <button type="submit" id="submit_parcel" class="btn btn-info" style="font-size:15px"> <i class="fa fa-plus"> </i> Tambah (F2)</button>
			  </div>
			</div>
			</div> <!-- END CARD BLOCK -->
		</form> <!-- END FORM -->

	</div> <!-- END collapseExample -->


	<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
	<span id="tabel-parcel">
		<table id="tabel_parcel" class="display table table-bordered table-sm">
			<thead>
			

				<th style='background-color: #4CAF50; color: white'> Kode Parcel </th>
				<th style='background-color: #4CAF50; color: white'> Nama Parcel</th>
				<th style='background-color: #4CAF50; color: white'> Harga Parcel 1</th>
				<th style='background-color: #4CAF50; color: white'> Harga Parcel 2</th>
				<th style='background-color: #4CAF50; color: white'> Harga Parcel 3</th>
				<th style='background-color: #4CAF50; color: white'> Harga Parcel 4</th>
				<th style='background-color: #4CAF50; color: white'> Harga Parcel 5</th>
				<th style='background-color: #4CAF50; color: white'> Harga Parcel 6</th>
				<th style='background-color: #4CAF50; color: white'> Harga Parcel 7</th>
				<th style='background-color: #4CAF50; color: white'> Petugas Input</th>
				<th style='background-color: #4CAF50; color: white'> Petugas Edit</th>
				<th style='background-color: #4CAF50; color: white'> Detail Parcel </th>
				<th style='background-color: #4CAF50; color: white'> Edit </th>
				<th style='background-color: #4CAF50; color: white'> Hapus </th>

			
			</thead>
		</table>
	</span>
	</div>

	</div> <!-- END CONTAINER -->


	<script type="text/javascript">
	 $("#kode_parcel").blur(function(){
	    var kode_parcel = $("#kode_parcel").val();
		 $.post("cek_data_parcel.php",{kode_parcel:kode_parcel},function(data){    
		     
		     if (data > 0) {
		          alert("KODE PARCEL SUDAH ADA !!");
		          $("#kode_parcel").val('');
		          $("#kode_parcel").focus();
		     }
		     
		 });
	});
	</script>


	<!--perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli -->
	<script>
	  $(document).on('click','#submit_parcel',function(){

	    var kode_parcel = $("#kode_parcel").val();
	    var nama_parcel = $("#nama_parcel").val();
	    var harga_parcel_1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_1").val()))));
	    var harga_parcel_2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_2").val()))));
	    var harga_parcel_3 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_3").val()))));
	    var harga_parcel_4 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_4").val()))));
	    var harga_parcel_5 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_5").val()))));
	    var harga_parcel_6 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_6").val()))));
	    var harga_parcel_7 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_7").val()))));
	       

	 if (kode_parcel == "") {
	  	alert ("SILAKAN ISI KODE PARCEL");
	  	$("#kode_parcel").focus();
	 }

	 else if (nama_parcel == "") {
	  	alert ("SILAKAN ISI NAMA PARCEL");
	  	$("#nama_parcel").focus();
	 }

	 else if (harga_parcel_1 == "") {
	  	alert ("SILAKAN ISI HARGA PARCEL 1");
	  	$("#harga_parcel_1").focus();
	 }

	 else
	 {


		$("#tambah_parcel").click();	

	 	$.post("proses_input_parcel.php",{kode_parcel:kode_parcel, nama_parcel:nama_parcel, harga_parcel_1:harga_parcel_1, harga_parcel_2:harga_parcel_2, harga_parcel_3:harga_parcel_3, harga_parcel_4:harga_parcel_4, harga_parcel_5:harga_parcel_5, harga_parcel_6:harga_parcel_6, harga_parcel_7:harga_parcel_7},function(data){
	     
	     $('#tabel_parcel').DataTable().destroy();
	     
	      var dataTable = $('#tabel_parcel').DataTable( {
	          "processing": true,
	          "serverSide": true,
	          "ajax":{
	            url :"datatable_perakitan_parcel.php", // json datasource
	            type: "post",  // method  , by default get
	            error: function(){  // error handling
	              $(".employee-grid-error").html("");
	              $("#tabel_parcel").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan !!</th></tr></tbody>');
	              $("#employee-grid_processing").css("display","none");
	              }
	          },
	             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

	              $(nRow).attr('class','tr-id-'+aData[13]+'');         

	          }
	        });


			$("#kode_parcel").val('');
			$("#nama_parcel").val('');
			$("#harga_parcel_1").val('');
			$("#harga_parcel_2").val('');
			$("#harga_parcel_3").val('');
			$("#harga_parcel_4").val('');
			$("#harga_parcel_5").val('');
			$("#harga_parcel_6").val('');
			$("#harga_parcel_7").val('');
	     
	     });

	 }//END ELSE


		$("#formparcel").submit(function(){
			return false;
		});
	    

	}); //END FUNCITON CLICK
	      
	</script>

	<script type="text/javascript">
	$(document).ready(function(){
		$(function(){
		    $(":input:first").focus();
		});
	});
	</script>


	<!--HAPUS PARCEL -->
	<script type="text/javascript">
	$(document).ready(function(){
	//jika dipilih, nim akan masuk ke input dan modal di tutup
	$(document).on('click', '.btn-hapus-parcel', function (e) {
	   
		var id = $(this).attr('data-id');


	                  $.post("hapus_data_parcel.php",{id:id},function(data){          
	                        $('#tabel_parcel').DataTable().destroy();

	                        var dataTable = $('#tabel_parcel').DataTable( {
	                          "processing": true,
	                          "serverSide": true,
	                          "ajax":{
	                            url :"datatable_perakitan_parcel.php", // json datasource
	                            type: "post",  // method  , by default get
	                            error: function(){  // error handling
	                              $(".employee-grid-error").html("");
	                              $("#tabel_parcel").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan !!</th></tr></tbody>');
	                              $("#employee-grid_processing").css("display","none");
	                              }
	                          },
	                             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

	                              $(nRow).attr('class','tr-id-'+aData[13]+'');         

	                          }
	                        });
	                  });



	});
	});

	</script>
	<!--HAPUS PARCEL-->


	<!--EDIT PARCEL -->
	<script type="text/javascript">
	$(document).on('click', '.btn-edit-parcel', function (e) {
		$("#modal_edit").modal('show');
	    var id_edit = $(this).attr("data-id");
	    var nama_parcel_edit = $(this).attr("data-nama");
	    var harga_parcel_edit_1 = $(this).attr("data-harga-1");
	    var harga_parcel_edit_2 = $(this).attr("data-harga-2");
	    var harga_parcel_edit_3 = $(this).attr("data-harga-3");
	    var harga_parcel_edit_4 = $(this).attr("data-harga-4");
	    var harga_parcel_edit_5 = $(this).attr("data-harga-5");
	    var harga_parcel_edit_6 = $(this).attr("data-harga-6");
	    var harga_parcel_edit_7 = $(this).attr("data-harga-7");

			$("#id_edit").val(id_edit);
			$("#nama_parcel_edit").val(nama_parcel_edit);
			$("#harga_parcel_edit_1").val(tandaPemisahTitik(harga_parcel_edit_1));
			$("#harga_parcel_edit_2").val(tandaPemisahTitik(harga_parcel_edit_2));
			$("#harga_parcel_edit_3").val(tandaPemisahTitik(harga_parcel_edit_3));
			$("#harga_parcel_edit_4").val(tandaPemisahTitik(harga_parcel_edit_4));
			$("#harga_parcel_edit_5").val(tandaPemisahTitik(harga_parcel_edit_5));
			$("#harga_parcel_edit_6").val(tandaPemisahTitik(harga_parcel_edit_6));
			$("#harga_parcel_edit_7").val(tandaPemisahTitik(harga_parcel_edit_7));
			
			
			});

	$(document).on('click','#simpan_parcel',function(e){
		var id_edit = $("#id_edit").val();
		var nama_parcel_edit = $("#nama_parcel_edit").val();
	    var harga_parcel_edit_1 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_edit_1").val()))));
	    var harga_parcel_edit_2 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_edit_2").val()))));
	    var harga_parcel_edit_3 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_edit_3").val()))));
	    var harga_parcel_edit_4 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_edit_4").val()))));
	    var harga_parcel_edit_5 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_edit_5").val()))));
	    var harga_parcel_edit_6 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_edit_6").val()))));
	    var harga_parcel_edit_7 = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#harga_parcel_edit_7").val()))));

	 if (nama_parcel_edit == "") {
	  	alert ("SILAKAN ISI NAMA PARCEL");
	  	$("#nama_parcel_edit").focus();
	 }

	 else if (harga_parcel_edit_1 == "") {
	  	alert ("SILAKAN ISI HARGA PARCEL 1");
	  	$("#harga_parcel_edit_1").focus();
	 }

	 else{
	 

		$("#close_edit").click();

		 $.post("update_data_parcel.php",{id_edit:id_edit, nama_parcel_edit:nama_parcel_edit, harga_parcel_edit_1:harga_parcel_edit_1, harga_parcel_edit_2:harga_parcel_edit_2, harga_parcel_edit_3:harga_parcel_edit_3, harga_parcel_edit_4:harga_parcel_edit_4, harga_parcel_edit_5:harga_parcel_edit_5, harga_parcel_edit_6:harga_parcel_edit_6, harga_parcel_edit_7:harga_parcel_edit_7},function(data){
	     
	     $('#tabel_parcel').DataTable().destroy();
	     
	      var dataTable = $('#tabel_parcel').DataTable( {
	          "processing": true,
	          "serverSide": true,
	          "ajax":{
	            url :"datatable_perakitan_parcel.php", // json datasource
	            type: "post",  // method  , by default get
	            error: function(){  // error handling
	              $(".employee-grid-error").html("");
	              $("#tabel_parcel").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan !!</th></tr></tbody>');
	              $("#employee-grid_processing").css("display","none");
	              }
	          },
	             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

	              $(nRow).attr('class','tr-id-'+aData[13]+'');         

	          }
	        });

			$("#nama_parcel_edit").val('');
			$("#harga_parcel_edit_1").val('');
			$("#harga_parcel_edit_2").val('');
			$("#harga_parcel_edit_3").val('');
			$("#harga_parcel_edit_4").val('');
			$("#harga_parcel_edit_5").val('');
			$("#harga_parcel_edit_6").val('');
			$("#harga_parcel_edit_7").val('');
	     
	     });

	}

	     $('#formparceledit').submit(function(){		
			return false;
		 });

		
	});

	</script>
	<!--END EDIT PARCEL -->


	<!--- AJAX DATATABLE -->
	<script type="text/javascript">
	$(document).ready(function(){

		  $('#tabel_parcel').DataTable().destroy();
	     
	      var dataTable = $('#tabel_parcel').DataTable( {
	          "processing": true,
	          "serverSide": true,
	          "ajax":{
	            url :"datatable_perakitan_parcel.php", // json datasource
	            type: "post",  // method  , by default get
	            error: function(){  // error handling
	              $(".employee-grid-error").html("");
	              $("#tabel_parcel").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan !!</th></tr></tbody>');
	              $("#employee-grid_processing").css("display","none");
	              }
	          },
	             "fnCreatedRow": function( nRow, aData, iDataIndex ) {

	              $(nRow).attr('class','tr-id-'+aData[13]+'');         

	          }
	        });


	});
	</script>
	<!--- AJAX DATATABLE -->





	<!-- SHORTCUT -->
	<script> 
	    shortcut.add("f1", function() {

	        $("#tambah_parcel").click();

	    });

	    
	    shortcut.add("f2", function() {

	        $("#submit_parcel").click();

	    });

	</script>
	<!-- SHORTCUT -->

	<?php include 'footer.php'; ?>