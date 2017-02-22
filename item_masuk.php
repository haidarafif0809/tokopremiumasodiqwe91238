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

<div class="container"><!--start of container-->

<h3><b> DATA ITEM MASUK </b></h3><hr>

<!--membuat link-->

<?php
$pilih_akses_item_masuk = $db->query("SELECT * FROM otoritas_item_masuk WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$item_masuk = mysqli_fetch_array($pilih_akses_item_masuk);

if ($item_masuk['item_masuk_tambah'] > 0) {

echo '<a href="form_item_masuk.php"  class="btn btn-info"> <i class="fa fa-plus"> </i> ITEM MASUK</a>';

}

?>
<br><br>

<div id="modal_alert" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert">
       </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Item Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nomor Faktur :</label>
     <input type="text" id="data_faktur" class="form-control" readonly="">
    
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
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
        <h4 class="modal-title">Detail Item Masuk </h4>
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
<table id="table_item_masuk" class="table table-bordered">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> User Edit </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal Edit </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php
if ($item_masuk['item_masuk_edit'] > 0) {

				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";

			}
?>

<?php
if ($item_masuk['item_masuk_hapus'] > 0) {
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
			$('#table_item_masuk').DataTable().destroy();
			
          var dataTable = $('#table_item_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_item_masuk.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_item_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[9]+'');
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
		var no_faktur = $(this).attr('no_faktur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_item_masuk.php',{no_faktur:no_faktur},function(info) {
		
		$("#modal-detail").html(info);
		
		
		});
		
		});
		
		</script>

		<script>
			
	//fungsi hapus data 
		$(document).on('click','.btn-hapus',function(e){
		var nama_item = $(this).attr("data-item");
		var id = $(this).attr("data-id");
		$("#data_faktur").val(nama_item);
		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);


		
		
		});


		$("#btn_jadi_hapus").click(function(){
		
		var no_faktur = $("#data_faktur").val();
		var id = $(this).attr("data-id");


		$.post("hapus_item_masuk.php",{no_faktur:no_faktur},function(data){
		

		
		$("#modal_hapus").modal('hide');
		$('#table_item_masuk').DataTable().destroy();
			
          var dataTable = $('#table_item_masuk').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_item_masuk.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_item_masuk").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[9]+'');
            },

        });
		});
		
		});
// end fungsi hapus data

		</script>


<script type="text/javascript">
	$(document).on('click', '.btn-alert', function (e) {
			var no_faktur = $(this).attr("data-faktur");
						
			$.post('modal_alert_hapus_data_item_masuk.php',{no_faktur:no_faktur},function(data){


			$("#modal_alert").modal('show');
			$("#modal-alert").html(data);

			});
	});
</script>


<?php 
include 'footer.php';
 ?>