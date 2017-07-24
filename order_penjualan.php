<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';



 ?>




<div class="container"><!--start of container-->






<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Penjualan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form action="hapus_data_penjualan_order.php" method="POST">
    <div class="form-group">
    <label>Kode Pelanggan :</label>
     <input type="text" id="kode_pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
     <input type="hidden" id="kode_meja" class="form-control" > 
     <input type="hidden" id="faktur_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" id="btn_jadi_hapus">Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
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
        <h4 class="modal-title">Detail Order Penjualan</h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
          <div class="table-responsive"> 
            <table id="tabledetailorder" class="table table-bordered">
              <thead>
                <th> Nomor Faktur </th>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th> Harga </th>
                <th> Potongan </th>
                <th> Tax </th>
                <th> Subtotal </th>
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
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Piutang atau Item Keluar</h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<h3>DATA ORDER PENJUALAN</h3>
<hr>



<?php 
include 'db.php';

$pilih_akses_penjualan_tambah = $db->query("SELECT penjualan_tambah FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_tambah = '1'");
$penjualan_tambah = mysqli_num_rows($pilih_akses_penjualan_tambah);


if ($penjualan_tambah > 0){
 echo '<a href="form_order_penjualan.php" class="btn btn-info" > <i class="fa fa-plus"> </i> ORDER PENJUALAN </a>';
}
?>


<style>


tr:nth-child(even){background-color: #f2f2f2}


</style>
<br>



<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="table_order" class="table table-bordered">
		<thead>

		
			
<?php 
include 'db.php';

$pilih_akses_penjualan_edit = $db->query("SELECT penjualan_edit FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_edit = '1'");
$penjualan_edit = mysqli_num_rows($pilih_akses_penjualan_edit);


    if ($penjualan_edit > 0){
				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";
			}
				
?>



<?php 
include 'db.php';

$pilih_akses_penjualan_hapus = $db->query("SELECT penjualan_hapus FROM otoritas_penjualan WHERE id_otoritas = '$_SESSION[otoritas_id]' AND penjualan_hapus = '1'");
$penjualan_hapus = mysqli_num_rows($pilih_akses_penjualan_hapus);


    if ($penjualan_hapus > 0){

			echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";

		}
?>
			<th style='background-color: #4CAF50; color:white'> Cetak Order </th>
			<th style='background-color: #4CAF50; color:white'> Detail </th>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Kode Pelanggan</th>
			<th style='background-color: #4CAF50; color:white'> Kode Gudang </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> Petugas Kasir </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Status Order </th>
			<th style='background-color: #4CAF50; color:white'> Keterangan </th>

		</thead>
		
	

	</table>
</span>
</div>


</div><!--end of container-->
		

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_order').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_order_penjualan.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[13]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->


<!--Start Ajax Modal DETAIL-->
<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
    $(document).on('click', '.detail', function (e) {
    $("#modal_detail").modal('show');

    var no_faktur = $(this).attr("no_faktur");

        $('#tabledetailorder').DataTable().destroy();

        var dataTable = $('#tabledetailorder').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_detail_penjualan_order.php", // json datasource
             "data": function ( d ) {
                  d.no_faktur = no_faktur;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#tabledetailorder").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

         

        });  
  
     }); 
  });
 </script>
<!--Ending Ajax Modal Detail-->


		<script type="text/javascript">
			$(document).ready(function(){
//fungsi hapus data

		$(document).on('click', '.btn-hapus', function (e) {

		var kode_pelanggan = $(this).attr("data-pelanggan");
		var id = $(this).attr("data-id");
		var no_faktur = $(this).attr("data-faktur");

		$("#kode_pelanggan").val(kode_pelanggan);
		$("#faktur_hapus").val(no_faktur);
    $("#id_hapus").val(id);



		$("#modal_hapus").modal('show');
		$("#btn_jadi_hapus").attr("data-id", id);
		
		
		});
});
</script>


    <script type="text/javascript">

    $(document).on('click', '#btn_jadi_hapus', function (e) {
		
		
		var id = $("#id_hapus").val();
		var no_faktur = $("#faktur_hapus").val();		
		
		$(".tr-id-"+id+"").remove();
		$("#modal_hapus").modal('hide');
		$.post("hapus_data_penjualan_order.php",{id:id,no_faktur:no_faktur},function(data){

		
		});
		
		
		});
</script>

<!--/Pagination teal-->

<?php 
include 'footer.php';
 ?>