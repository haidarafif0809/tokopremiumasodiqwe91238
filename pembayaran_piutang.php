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

<h3><b>DATA PEMBAYARAN PIUTANG</b></h3><hr>
<!--membuat link-->


<?php
$pilih_akses_pembayaran_piutang = $db->query("SELECT * FROM otoritas_pembayaran WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$pembayaran_piutang = mysqli_fetch_array($pilih_akses_pembayaran_piutang);

if ($pembayaran_piutang['pembayaran_piutang_tambah'] > 0) {

echo '<a href="form_pembayaran_piutang.php" class="btn btn-info"> <i class="fa fa-plus"> </i> PEMBAYARAN PIUTANG</a>';
}
?>




<br><br>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Pembayaran Piutang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Pelanggan :</label>
     <input type="text" id="pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 

     <input type="hidden" id="no_faktur_hapus" class="form-control" readonly=""> 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Pembayaran Piutang </h4>
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



<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel-baru">
<table id="table_pembayaran_piutang" class="table table-bordered">
		<thead>
			<th style="background-color: #4CAF50; color:white"> Detail </th>

<?php

if ($pembayaran_piutang['pembayaran_piutang_edit'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
}
?>

<?php

if ($pembayaran_piutang['pembayaran_piutang_hapus'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}
?>

			<th style="background-color: #4CAF50; color:white"> Cetak </th>
			<th style="background-color: #4CAF50; color:white"> Nomor Faktur </th>
			<th style="background-color: #4CAF50; color:white"> Tanggal </th>
			<th style="background-color: #4CAF50; color:white"> Jam </th>
			<th style="background-color: #4CAF50; color:white"> Kode Pelanggan </th>
			<th style="background-color: #4CAF50; color:white"> Keterangan </th>
			<th style="background-color: #4CAF50; color:white"> Total </th>
			<th style="background-color: #4CAF50; color:white"> User Buat </th>
			<th style="background-color: #4CAF50; color:white"> User Edit </th>
			<th style="background-color: #4CAF50; color:white"> Tanggal Edit </th>
			<th style="background-color: #4CAF50; color:white"> Ke Kas </th>
			
		</thead>
		
	</table>
</span>
</div>

		<br>
		<button type="submit" id="submit_close" class="glyphicon glyphicon-remove btn btn-danger" style="display:none"></button> 
		<span id="demo"> </span>
</div><!--end of container-->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
          var dataTable = $('#table_pembayaran_piutang').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_pembayaran_piutang.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_pembayaran_piutang").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[14]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->

<script type="text/javascript">
$(document).on('click','.detail',function(e){
		var no_faktur_pembayaran = $(this).attr('no_faktur_pembayaran');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_pembayaran_piutang.php',{no_faktur_pembayaran:no_faktur_pembayaran},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
</script>

 <script type="text/javascript">
			
//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var pelanggan = $(this).attr("data-suplier");
		var id = $(this).attr("data-id");
		var no_faktur_pembayaran = $(this).attr("data-no-faktur");


		$("#no_faktur_hapus").val(no_faktur_pembayaran);
		$("#pelanggan").val(pelanggan);
		$("#id_hapus").val(id);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var id = $(this).attr("data-id");
		var no_faktur_pembayaran = $("#no_faktur_hapus").val();

		$.post("hapus_data_pembayaran_piutang.php",{id:id, no_faktur_pembayaran:no_faktur_pembayaran},function(data){
		if (data != "") {

		$("#modal_hapus").modal('hide');
		$(".tr-id-"+id).remove();
		
		}

		
		});
		
		
		});




		</script>




<?php 
include 'footer.php';
 ?>