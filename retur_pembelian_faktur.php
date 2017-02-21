<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>



<div class="container"> <!--start of container-->

<h3><b> DATA RETUR PEMBELIAN FAKTUR </b></h3><hr>

<!--membuat link-->
<?php

$pilih_akses_pembelian = $db->query("SELECT * FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$pembelian = mysqli_fetch_array($pilih_akses_pembelian);

if ($pembelian['retur_pembelian_tambah'] > 0) {

echo '<a href="form_retur_pembelian_faktur.php"  class="btn btn-info"><i class="fa fa-plus"> </i> RETUR PEMBELIAN FAKTUR</a>';

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
        <h4 class="modal-title">Konfirmasi Hapus Data Retur Pembelian</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Suplier :</label>
     <input type="text" id="data_suplier" class="form-control" readonly=""> 

     <input type="hidden" id="data_faktur" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
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
        <h4 class="modal-title">Detail Retur Pembelian </h4>
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

<style>


tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel_baru">
<table id="table_retur_pembelian_faktur" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php
if ($pembelian['retur_pembelian_edit'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
   }
?>

<?php
if ($pembelian['retur_pembelian_hapus'] > 0) {
    	echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
   }
?>

			<th style='background-color: #4CAF50; color:white'> Cetak </th>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur Retur </th>
			<th style='background-color: #4CAF50; color:white'> Nama Suplier </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Potongan </th>
			<th style='background-color: #4CAF50; color:white'> Tax </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User Buat </th>
			<th style='background-color: #4CAF50; color:white'> User Edit </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Edit</th>
			<th style='background-color: #4CAF50; color:white'> Tunai </th>
			<th style='background-color: #4CAF50; color:white'> Kembalian </th>
			
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
			$('#table_retur_pembelian_faktur').DataTable().destroy();
			
          var dataTable = $('#table_retur_pembelian_faktur').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_retur_pembelian_faktur.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_retur_pembelian_faktur").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[16]+'');
            },

        });

        $("form").submit(function(){
        return false;
        });
		
		});
		
</script>


				<!--menampilkan detail penjualan-->
	<script type="text/javascript">
	
		$(document).on('click','.detail',function(e){
		var no_faktur_retur = $(this).attr('no_faktur_retur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_retur_pembelian_faktur.php',{no_faktur_retur:no_faktur_retur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});

				
</script>
				
				<script type="text/javascript">
				
				//fungsi hapus data 
				$(document).on('click','.btn-hapus',function(e){
				var kode_suplier = $(this).attr("data-suplier");
				var no_faktur_retur = $(this).attr("data-faktur");
				var id = $(this).attr("data-id");
				$("#data_suplier").val(kode_suplier);
				$("#data_faktur").val(no_faktur_retur);
				$("#id_hapus").val(id);
				$("#modal_hapus").modal('show');
				$("#btn_jadi_hapus").attr("data-id", id);
				
				
				});
				
				$("#btn_jadi_hapus").click(function(){
				
				var id = $(this).attr("data-id");
				var no_faktur_retur =  $("#data_faktur").val();

				$.post("hapus_data_retur_pembelian_faktur.php",{no_faktur_retur:no_faktur_retur,id:id},function(data){
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