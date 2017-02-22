<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>




<style>
.table {
    border-collapse: collapse;
    width: 100%;
}

.th, .td {
    text-align: left;
    padding: 8px;
}

.tr:nth-child(even){background-color: #f2f2f2}

.th {
    background-color: #4CAF50;
    color: white;
}
</style>

<div class="container"> <!--start of container-->

<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Target Penjualan</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label>Nomor Transaksi :</label>
     <input type="text" id="faktur_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control">
    </div>
   
   </form>
   
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class="fa fa-check"> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class="fa fa-close"> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<div id="modal_detail" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg" role="document">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Target Penjualan</h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>


        <div class="table-responsive"> 
          <table id="table-detail" class="table table-striped">
          <thead>
              <th> Kode Barang </th>
              <th> Nama Barang </th>
              <th> Satuan </th>
              <th> Penjualan Periode </th>
              <th> Penjualan Per Hari </th>
              <th> Target Per Hari </th>
              <th> Proyeksi Penjualan Periode </th>
              <th> Stok Sekarang</th>
              <th> Kebutuhan </th>
          </thead>
          
          </table>
          </div>



      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<h3>ESTIMASI ORDER BERDASARKAN TARGET PENJUALAN </h3>
<hr>


<?php 
include 'db.php';

$pilih_akses_target_jual_lihat = $db->query("SELECT target_jual_lihat FROM otoritas_target_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND target_jual_lihat = '1'");
$target_jual_lihat = mysqli_num_rows($pilih_akses_target_jual_lihat);


    if ($target_jual_lihat > 0){
// membuat link-->
echo '<a href="target_penjualan.php"  class="btn btn-info"> <i class="fa fa-plus"></i></a>';

}
?>



<br><br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru" > 
<table id="table_target" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color:white' class='th'> Detail </th>

<!---------

include 'db.php';

$pilih_akses_target_jual_edit = $db->query("SELECT target_jual_edit FROM otoritas_target_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND target_jual_edit = '1'");
$target_jual_edit = mysqli_num_rows($pilih_akses_target_jual_edit);


    if ($target_jual_edit > 0){
        echo "<th style='background-color: #4CAF50; color:white' class='th'> Edit </th>";

      }

-------------->


<?php 
include 'db.php';

$pilih_akses_target_jual_hapus = $db->query("SELECT target_jual_hapus FROM otoritas_target_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND target_jual_hapus = '1'");
$target_jual_hapus = mysqli_num_rows($pilih_akses_target_jual_hapus);


    if ($target_jual_hapus > 0){
				echo "<th style='background-color: #4CAF50; color:white' class='th'> Hapus </th>";
	}
	?>
			
			<th style='background-color: #4CAF50; color:white' class='th'> Cetak </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Nomor Transaksi </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Keterangan </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Order Untuk </th>
			<th style='background-color: #4CAF50; color:white' class='th'> User </th>
      <th style='background-color: #4CAF50; color:white' class='th'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white' class='th'> Jam </th>			
		</thead>
		
		
	</table>
</span>
</div>

		<br>
		<span id="demo"> </span>

</div><!--end of container-->

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {
          $('#table_target').DataTable().destroy();
          var status = $("#status").val();
          var dataTable = $('#table_target').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_target.php", // json datasource
            "data": function ( d ) {
                      d.status = $("#status").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_target").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#table_target_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[9]);
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->

<!--menampilkan detail penjualan-->
		<script type="text/javascript">
		
		$(document).on('click','.detail',function(e){

		var no_trx = $(this).attr('no_trx');
				
		$("#modal_detail").modal('show');

      $('#table-detail').DataTable().destroy();

          var dataTable = $('#table-detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_detail_target_jual.php", // json datasource
             "data": function ( d ) {
                d.no_trx = no_trx;
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-detail").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table-detail_processing").css("display","none");
              
            }
          }
    


        } );

		
		});
		
		</script>
		
		
		


		<script type="text/javascript">
						$(document).ready(function(){
						//fungsi hapus data 
						$(document).on('click', '.btn-hapus', function (e) {
						var no_trx = $(this).attr("data-trx");
						var id = $(this).attr("data-id");

						$("#faktur_hapus").val(no_trx);
						$("#id_hapus").val(id);
						$("#modal_hapus").modal('show');
						$("#btn_jadi_hapus").attr("data-id", id);

						});
						
            $(document).on('click', '#btn_jadi_hapus', function (e) {

						
						var id = $(this).attr("data-id");
						var no_trx = $("#faktur_hapus").val();

						$.post("hapus_data_target_jual.php", {id:id, no_trx:no_trx}, function(data){

						$("#modal_hapus").modal("hide");
						$(".tr-id-"+id).remove();
						
						
						});
						
						
						});
						
						$('form').submit(function(){
						
						return false;
						});
						});

		</script>

	



<?php 
include 'footer.php';
 ?>