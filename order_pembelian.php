<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

  $pilih_akses_tombol = $db->query("SELECT order_pembelian_tambah, order_pembelian_edit, order_pembelian_hapus FROM otoritas_order_pembelian WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
  $otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

?>

<div style="padding-left: 5%; padding-right: 5%">


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data Order Pembelian</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form action="hapus_data_pembelian_order.php" method="POST">
    <div class="form-group">
    <label>Suplier :</label>
     <input type="text" id="suplier" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
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
        <h4 class="modal-title">Detail Order Pembelian</h4>
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
        <h6 style="text-align: left"><i> * jika ingin menghapus atau mengedit data,<br>
        silahkan hapus terlebih dahulu Transaksi Pembayaran Piutang atau Item Keluar</h6>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<h3>DATA ORDER PEMBELIAN</h3>
<hr>

<?php if ($otoritas_tombol['order_pembelian_tambah']): ?>
  <a href="form_order_pembelian.php" class="btn btn-info" > <i class="fa fa-plus"> </i> ORDER PEMBELIAN </a>  
<?php endif ?>

<style>
  tr:nth-child(even){background-color: #f2f2f2}
</style>
<br>



<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="table-baru">
<table id="table_order" class="table table-bordered table-sm">
    <thead>

<?php if ($otoritas_tombol['order_pembelian_edit'] > 0): ?>  
      <th style='background-color: #4CAF50; color:white'> Edit </th>
<?php endif ?>

<?php if ($otoritas_tombol['order_pembelian_hapus'] > 0): ?>  
      <th style='background-color: #4CAF50; color:white'> Hapus </th>
<?php endif ?>

      <th style='background-color: #4CAF50; color:white'> Cetak </th>
      <th style='background-color: #4CAF50; color:white'> Detail </th>
      <th style='background-color: #4CAF50; color:white'> Nomor Faktur </th>
      <th style='background-color: #4CAF50; color:white'> Suplier </th>
      <th style='background-color: #4CAF50; color:white'> Gudang </th>
      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jam </th>
      <th style='background-color: #4CAF50; color:white'> Petugas </th>
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
            url :"datatable_order_pembelian.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_order").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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
    
    $(document).on('click', '.detail', function (e) {
    var no_faktur = $(this).attr('no_faktur');
    
    
    $("#modal_detail").modal('show');
    
    $.post('proses_detail_pembelian_order.php',{no_faktur:no_faktur},function(info) {
    
    $("#modal-detail").html(info);
    
    
    });
    
    });
    
    </script>


    <script type="text/javascript">
      $(document).ready(function(){
//fungsi hapus data

    $(document).on('click', '.btn-hapus', function (e) {

    var suplier = $(this).attr("data-suplier");
    var nama = $(this).attr("data-nama");
    var id = $(this).attr("data-id");
    var no_faktur = $(this).attr("data-faktur");

    $("#suplier").val(nama);
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
    
    $("#modal_hapus").modal('hide');
    $.post("hapus_data_pembelian_order.php",{id:id,no_faktur:no_faktur},function(data){

      var table_order = $('#table_order').DataTable();
          table_order.draw();
    
    });
    
    
    });
</script>

<!--/Pagination teal-->

<?php 
include 'footer.php';
 ?>