<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>

<style>
tr:nth-child(even){background-color: #f2f2f2}
</style>

<div class="container"> <!--start of container-->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Kas Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
   <div class="form-group">
					<label> Nomor Faktur :</label>
					<input type="text" id="hapus_no_faktur" class="form-control" readonly="">		
					<input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
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
        <h4 class="modal-title">Edit Data Kas Masuk</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
    
		<label> Jumlah Baru </label><br>
		<input type="text" name="jumlah_baru" id="jumlah_baru" autocomplete="off" class="form-control" required="">
					

		<input type="hidden" name="jumlah" id="jumlah_lama" class="form-control" readonly="" required="">	
					

		<input type="hidden" name="ke_akun" id="ke_akun" class="form-control" readonly="" required="">
					

					
		<label> Keterangan </label><br>
		<textarea type="text" name="keterangan" id="keterangan" class="form-control"></textarea>

		<input type="hidden" id="id_edit" class="form-control" > 
    
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

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Kas Masuk </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">

      <span id="modal-detail"> </span>
 	
 	<table id="table_modal_detail" class="table table-bordered table-sm">
  	<thead> <!-- untuk memberikan nama pada kolom tabel -->

          <th> No Faktur </th>
          <th> Dari Akun </th>
          <th> Ke Akun </th>
          <th> Jumlah Barang </th>
          <th> Tanggal </th>
          <th> Jam </th>
          <th> Keterangan </th>
          <th> Petugas </th>
          
  	</thead> <!-- tag penutup tabel -->
  	</table>

       <input type="hidden" name="no_faktur_detail" class="form-control " id="no_faktur_detail" placeholder="no_faktur  "/>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<h3><b>DATA KAS MASUK</b></h3><hr>

<?php
$pilih_akses_kas_masuk = $db->query("SELECT * FROM otoritas_kas_masuk WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$kas_masuk = mysqli_fetch_array($pilih_akses_kas_masuk);

if ($kas_masuk['kas_masuk_tambah'] > 0) {

echo '<a href="form_kas_masuk.php"  class="btn btn-info"><i class="fa fa-plus"> </i> KAS MASUK</a>';
}
?>

<br><br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel-baru">
<table id="table_kas_masuk" class="table table-bordered">
		<thead>

			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Ke Akun </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> Cetak </th>

			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php

if ($kas_masuk['kas_masuk_edit'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>

<?php

if ($kas_masuk['kas_masuk_hapus'] > 0) {

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>
			
			
			
		</thead>
	</table>
</span>
</div>
<br>
		<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
		<span id="demo"> </span>


</div><!--end of container-->

<script type="text/javascript">
	$(document).ready(function(){
			$('#table_kas_masuk').DataTable().destroy();
			
          var dataTable = $('#table_kas_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_kas_masuk.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_kas_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[10]+'');
            },

        });

        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>



<!--Start Ajax Modal DETAIL-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    $(document).on('click', '.detail', function (e) {
    $("#modal_detail").modal('show');

    var no_faktur = $(this).attr("no_faktur");
    $("#no_faktur_detail").val(no_faktur);
      var no_faktur_detail = $("#no_faktur_detail").val();
          
          $('#table_modal_detail').DataTable().destroy();

        var dataTable = $('#table_modal_detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_detail_kas_masuk.php", // json datasource
             "data": function ( d ) {
                  d.no_faktur = $("#no_faktur_detail").val();
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_modal_detail").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

         

        });  
  
     }); 
  });
 </script>
<!--Ending Ajax Modal Detail-->

<!--<script type="text/javascript">
		$(document).on('click','.detail',function(e){
		var no_faktur = $(this).attr('no_faktur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_kas_masuk.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
</script>-->


	
<script type="text/javascript">			
//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var no_faktur = $(this).attr("no-faktur");
		var id = $(this).attr("data-id");
		$("#hapus_no_faktur").val(no_faktur);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
		
		$("#btn_jadi_hapus").click(function(){
		
		var id = $(this).attr("data-id");
		var no_faktur = $("#hapus_no_faktur").val();

		$.post("hapus_kas_masuk.php",{id:id,no_faktur:no_faktur},function(data){
		if (data != "") {

		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id).remove();
		
		}
		
		});
		
		
		});

		//fungsi edit data 
		$(".btn-edit").click(function(){
		
		$("#modal_edit").modal('show');
		var jumlah = $(this).attr("data-jumlah");
		var ke_akun = $(this).attr("data-akun");
		var id  = $(this).attr("data-id");
		$("#jumlah_lama").val(jumlah);
		$("#ke_akun").val(ke_akun);
		$("#id_edit").val(id);
		
		
		});
		
		$("#submit_edit").click(function(){
		var jumlah_baru = $("#jumlah_baru").val();
		var jumlah = $("#jumlah_lama").val();
		var ke_akun = $("#ke_akun").val();
		var keterangan = $("#keterangan").val();
		var id = $("#id_edit").val();

		$.post("update_kas_masuk.php",{id:id,jumlah_baru:jumlah_baru,jumlah:jumlah,ke_akun:ke_akun,keterangan:keterangan},function(data){

		$(".alert").show('fast');
		$("#tabel-baru").load('tabel-kas-masuk.php');
		$("#modal_edit").modal('hide');
		

		});
		});
		


//end function edit data

		$('form').submit(function(){
		
		return false;
		});

</script>

<?php 
include 'footer.php';
 ?>