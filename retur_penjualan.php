<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


?>



<div class="container"> <!--start of container-->

<h3><b> DATA RETUR PENJUALAN </b></h3><hr>

<!--membuat link-->

<?php
include 'db.php';

$pilih_akses_retur_penjualan = $db->query("SELECT * FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$retur_penjualan = mysqli_fetch_array($pilih_akses_retur_penjualan);

if ($retur_penjualan['retur_penjualan_tambah'] > 0) {

echo '<a href="form_retur_penjualan.php"  class="btn btn-info"><i class="fa fa-plus"></i> RETUR PENJUALAN</a>';

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
    <label> Kode Pelanggan :</label>
     <input type="text" id="data_pelanggan" class="form-control" readonly=""> 
    <label> No faktur :</label>
     <input type="text" id="hapus_faktur" class="form-control" readonly=""> 
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
        <h4 class="modal-title">Detail Retur Penjualan </h4>
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
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data, 
        silahkan hapus terlebih dahulu<br> Transaksi yang diatas.</i></h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<style>


tr:nth-child(even){background-color: #f2f2f2}

</style>

<div class="table-responsive">
	<span id="tabel_baru">
		<table id="table_retur_penjualan" class="table table-bordered table-sm">
			<thead>
				<th style='background-color: #4CAF50; color:white'> Detail </th>

				<?php
				if ($retur_penjualan['retur_penjualan_edit'] > 0) {
				    	echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
				   }
				?>

				<?php
				if ($retur_penjualan['retur_penjualan_hapus'] > 0) {
				    	echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
				   }
				?>

				<th style='background-color: #4CAF50; color:white'> Cetak </th>
				<th style='background-color: #4CAF50; color:white'> Faktur Retur </th>
				<th style='background-color: #4CAF50; color:white'> Kode Pelanggan </th>
				<th style='background-color: #4CAF50; color:white'> Total Retur </th>
				<th style='background-color: #4CAF50; color:white'> Potong Piutang </th>
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
			$('#table_retur_penjualan').DataTable().destroy();
			
          var dataTable = $('#table_retur_penjualan').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_retur_penjualan.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_retur_penjualan").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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
		<script>
		
		$(document).ready(function(){		
		
		$(document).on('click','.detail',function(e){
		var no_faktur_retur = $(this).attr('no_faktur_retur');
		
		
		$("#modal_detail").modal('show');
		
		$.post('detail_retur_penjualan.php',{no_faktur_retur:no_faktur_retur},function(info) {
		
		$("#modal-detail").html(info);

				var table_retur_penjualan = $('#table_retur_penjualan').DataTable();
              		table_retur_penjualan.draw();		
		
		});
		
		});
		});
		
		</script>

				<script type="text/javascript">
				
				//fungsi hapus data 
				$(document).on('click','.btn-hapus',function(e){
				var kode_pelanggan = $(this).attr("data-pelanggan");
				var no_faktur_retur = $(this).attr("data-faktur");
				var id = $(this).attr("data-id");
				$("#data_pelanggan").val(kode_pelanggan);
				$("#hapus_faktur").val(no_faktur_retur);
				$("#id_hapus").val(id);
				$("#modal_hapus").modal('show');
				$("#btn_jadi_hapus").attr("data-id", id);
				
				
				});
				
				$("#btn_jadi_hapus").click(function(){
				
				
				var id = $(this).attr("data-id");
				var no_faktur_retur =$("#hapus_faktur").val();

				$.post("hapus_data_retur_penjualan.php",{id:id, no_faktur_retur:no_faktur_retur},function(data){
				if (data != "") {
				
				$("#modal_hapus").modal('hide');
				$(".tr-id-"+id).remove();
				
				}

				var table_retur_penjualan = $('#table_retur_penjualan').DataTable();
              		table_retur_penjualan.draw();
				
				});
				
				
				});
				
				
				</script>


<script type="text/javascript">
	
		$(document).on('click', '.btn-alert', function (e) {
		var no_faktur = $(this).attr("data-faktur");

		$.post('modal_alert_hapus_data_retur_penjualan.php',{no_faktur:no_faktur},function(data){


		$("#modal_alert").modal('show');
		$("#modal-alert").html(data);

		});

		
		});

</script>


<?php 
include 'footer.php';
 ?>