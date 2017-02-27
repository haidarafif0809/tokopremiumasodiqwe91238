<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

 ?>



<div class="container"> <!--start of container-->

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
        silahkan hapus terlebih dahulu Transaksi Pembayaran Hutang atau Retur Pembelian atau Penjualan</i></h6>
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
        <h4 class="modal-title">Konfirmsi Hapus Data Pembelian</h4>
      </div>
      <div class="modal-body">
   <p>Apakah Anda yakin Ingin Menghapus Data Pembelian Dengan Suplier ini ?</p>
   <form >
    <div class="form-group">
    <label>Nama Suplier :</label>
     <input type="text" id="nama_suplier" class="form-control" readonly=""> 
    <label>Nomor Faktur :</label>
     <input type="text" id="faktur_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control">
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class="glyphicon glyphicon-ok-sign"> </span>Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class="glyphicon glyphicon-remove-sign"> </span>Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

  <!-- Tampilan Modal Produk Parcel -->
  <div id="ModalDetailProdukPembelian" class="modal fade" role="dialog">
    <div class="modal-dialog ">
      <!-- Isi Modal-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Produk Pembelian</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->

          <div class="table-responsive">
            <center>
              <table id="table_detail_produk_pembelian" class="table table-bordered table-sm">
                <thead> <!-- untuk memberikan nama pada kolom tabel -->

                  <th> Nomor Faktur </th>
                  <th> Kode Barang </th>
                  <th> Nama Barang </th>
                  <th> Jumlah Barang </th>
                  <th> Satuan </th>
                  <th> Harga </th>
                  <th> Potongan </th>
                  <th> Subtotal </th>
                  <th> Tax </th>
                  <th> Sisa Barang </th>

                </thead> <!-- tag penutup tabel -->
              </table>
              </center>
          </div> 

        </div><!-- tag penutup modal body -->
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
      </div>

    </div>
  </div><!-- END Tampilan Modal Produk Parcel --> <!-- END Tampilan Modal Produk Parcel --> <!-- END Tampilan Modal Produk Parcel --> <!-- END Tampilan Modal Produk Parcel --> 

<h3>DATA PEMBELIAN</h3>
<hr>


<style>


tr:nth-child(even){background-color: #f2f2f2}


</style>

<?php 
include 'db.php';

$pilih_akses_pembelian_lihat = $db->query("SELECT pembelian_lihat FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_lihat = '1'");
$pembelian_lihat = mysqli_num_rows($pilih_akses_pembelian_lihat);


    if ($pembelian_lihat > 0){
// membuat link-->
echo '<a href="formpembelian.php"  class="btn btn-info"> <i class="fa fa-plus"> </i> PEMBELIAN</a>';

}
?>
<br><br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru" > 
<table id="table_pembelian" class="table table-bordered table-sm">
		<thead>
			<th style='background-color: #4CAF50; color:white'> Detail </th>

<?php 
include 'db.php';

$pilih_akses_pembelian_edit = $db->query("SELECT pembelian_edit FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_edit = '1'");
$pembelian_edit = mysqli_num_rows($pilih_akses_pembelian_edit);


    if ($pembelian_edit > 0){
				echo "<th style='background-color: #4CAF50; color:white'> Edit </th>";

			}
?>

<?php 
include 'db.php';

$pilih_akses_pembelian_hapus = $db->query("SELECT pembelian_hapus FROM otoritas_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' AND pembelian_hapus = '1'");
$pembelian_hapus = mysqli_num_rows($pilih_akses_pembelian_hapus);


    if ($pembelian_hapus > 0){
				echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
	}
	?>
			
			<th style='background-color: #4CAF50; color:white'> Cetak Tunai </th>
			<th style='background-color: #4CAF50; color:white'> Cetak Hutang </th>
			<th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
			<th style='background-color: #4CAF50; color:white'> Gudang </th>
			<th style='background-color: #4CAF50; color:white'> Suplier </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal JT </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>
			<th style='background-color: #4CAF50; color:white'> Status </th>
			<th style='background-color: #4CAF50; color:white'> Potongan </th>
			<th style='background-color: #4CAF50; color:white'> Tax </th>
			<th style='background-color: #4CAF50; color:white'> Kembalian</th>
			<th style='background-color: #4CAF50; color:white'> Kredit </th>
			
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
          $('#table_pembelian').DataTable().destroy();
          var status = $("#status").val();
          var dataTable = $('#table_pembelian').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_pembelian.php", // json datasource
            "data": function ( d ) {
                      d.status = $("#status").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[18]+'');
            },
        });

        $("#form").submit(function(){
        return false;
        });
        

      } );
    </script>
<!--/DATA TABLE MENGGUNAKAN AJAX-->



<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.detail',function(){

      var no_faktur = $(this).attr('no_faktur');

    $("#ModalDetailProdukPembelian").modal('show');
    $("#table_detail_produk_pembelian").DataTable().destroy();
          var dataTable = $('#table_detail_produk_pembelian').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"proses_detail_pembelian.php", // json datasource
            "data": function ( d ) {
                  d.no_faktur = no_faktur;
                  // d.custom = $('#myInput').val();
                  // etc
              },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_detail_produk_pembelian").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          }

      }); 
  });
  });
</script>


		
		
		


		<script type="text/javascript">
						$(document).ready(function(){
						//fungsi hapus data 
						$(document).on('click', '.btn-hapus', function (e) {
						var suplier = $(this).attr("data-suplier");
						var no_faktur = $(this).attr("data-faktur");
						var id = $(this).attr("data-id");

						$("#nama_suplier").val(suplier);
						$("#faktur_hapus").val(no_faktur);
						$("#id_hapus").val(id);
						$("#modal_hapus").modal('show');
						$("#btn_jadi_hapus").attr("data-id", id);

						});
						
						$("#btn_jadi_hapus").click(function(){
						
						var id = $(this).attr("data-id");
						var no_faktur = $("#faktur_hapus").val();

						$.post("hapus_data_pembelian.php", {id:id, no_faktur:no_faktur}, function(data){
						if (data == 'sukses') {
						
						$("#modal_hapus").modal("hide");
						$(".tr-id-"+id).remove();
						
						}
						
						});
						
						
						});
						
						$('form').submit(function(){
						
						return false;
						});
						});

		</script>


<script type="text/javascript">
	$(document).on('click', '.btn-alert', function (e) {
			var no_faktur = $(this).attr("data-faktur");
						
			$.post('modal_alert_hapus_data_pembelian.php',{no_faktur:no_faktur},function(data){


			$("#modal_alert").modal('show');
			$("#modal-alert").html(data);

			});
	});
</script>

		



<?php 
include 'footer.php';
 ?>