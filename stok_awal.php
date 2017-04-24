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

<h3><b> DATA STOK AWAL </b></h3><hr>

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
        <h6 style="text-align: left"><i> * jika ingin menghapus data,<br>
        silahkan hapus terlebih dahulu Transaksi Penjualan atau Item Keluar</i></h6>
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
        <h4 class="modal-title">Konfirmsi Hapus Data Stok Awal</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_barang" class="form-control" readonly=""> 
     <input type="hidden" id="hapus_faktur" class="form-control" readonly=""> 
     <input type="hidden" id="kode_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Hapus
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" data-id="" class="btn btn-info" data-id="" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!--membuat link-->

<?php
$pilih_akses_stok_awal = $db->query("SELECT * FROM otoritas_stok_awal WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$stok_awal = mysqli_fetch_array($pilih_akses_stok_awal);

if ($stok_awal['stok_awal_tambah'] > 0) {

echo '<a href="form_stok_awal.php"  class="btn btn-info"> <i class="fa fa-plus"> </i> STOK AWAL</a>';
}

?>

<br><br>

<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel_baru">
<table id="table_stok_awal" class="table table-bordered">
		<thead>
      <th style='background-color: #4CAF50; color:white'> Kode Barang </th>
			<th style='background-color: #4CAF50; color:white'> Nama Barang </th>
			<th style='background-color: #4CAF50; color:white'> Jumlah </th>
			<th style='background-color: #4CAF50; color:white'> Satuan </th>
			<th style='background-color: #4CAF50; color:white'> Harga </th>
			<th style='background-color: #4CAF50; color:white'> Total </th>
			<th style='background-color: #4CAF50; color:white'> Tanggal </th>
			<th style='background-color: #4CAF50; color:white'> Jam </th>
			<th style='background-color: #4CAF50; color:white'> User </th>

<?php

if ($stok_awal['stok_awal_hapus'] > 0) {
    echo "<th style='background-color: #4CAF50; color:white'> Hapus </th>";
}

?>
			
			
			
		</thead>

	</table>
</span>
</div>
<h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom jumlah jika ingin mengedit.</i></h6>
</div><!--end of container-->

<script type="text/javascript">
  $(document).ready(function(){
      $('#table_stok_awal').DataTable().destroy();
      
          var dataTable = $('#table_stok_awal').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_stok_awal.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_stok_awal").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
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

                              <script type="text/javascript">
                               
                                  $(document).ready(function(){
                                  
                                  //fungsi hapus data 
                                   $(document).on('click', '.btn-hapus', function (e) {
                                  var nama_barang = $(this).attr("data-nama-barang");
                                  var kode_barang = $(this).attr("data-kode-barang");
                                  var no_faktur = $(this).attr("data-faktur");
                                  var id = $(this).attr("data-id");
                                  $("#hapus_barang").val(nama_barang);
                                  $("#hapus_faktur").val(no_faktur);
                                  $("#kode_hapus").val(kode_barang);
                                  $("#modal_hapus").modal('show');
                                  $("#btn_jadi_hapus").attr("data-id", id);
                                  
                                  
                                  });
                                  
                                  $("#btn_jadi_hapus").click(function(){
                                  
                                  var kode_barang = $("#kode_hapus").val();
                                  var no_faktur = $("#hapus_faktur").val();
                                  var id = $(this).attr("data-id");

                                  $.post("hapus_data_stok_awal.php",{no_faktur:no_faktur,kode_barang:kode_barang},function(data){

                                  if (data != '') {

                                  
                                  $("#modal_hapus").modal('hide');
                                  $(".tr-id-"+id).remove();
                                  
                                  
                                  }
                                  });
                                  
                                  
                                  });
                                  });
                                  
                                  //end fungsi hapus data

                             </script>

<script type="text/javascript">
  
    $(document).on('click', '.btn-alert', function (e) {
    var no_faktur = $(this).attr("data-faktur");
    var kode_barang = $(this).attr("data-kode-barang");

    $.post('modal_hapus_data_stok_awal.php',{kode_barang:kode_barang, no_faktur:no_faktur},function(data){


    $("#modal_alert").modal('show');
    $("#modal-alert").html(data);

    });

    
    });

</script>


<script type="text/javascript">
  
    $(document).on('click', '.edit-alert', function (e) {

    var kode_barang = $(this).attr("data-kode-barang");
    var no_faktur = $(this).attr("data-faktur");

    $.post('modal_hapus_data_stok_awal.php',{no_faktur:no_faktur,kode_barang:kode_barang},function(data){


    $("#modal_alert").modal('show');
    $("#modal-alert").html(data);

    });

    
    });

</script>

                                 
                              <script type="text/javascript">
                                 
                                 $(document).on('dblclick','.edit-jumlah',function(e){

                                    var id = $(this).attr("data-id");

                                    $("#text-jumlah-"+id+"").hide();

                                    $("#input-jumlah-"+id+"").attr("type", "text");

                                 });


                                 $(document).on('blur','.input_jumlah',function(e){

                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var harga = $(this).attr("data-harga");
                                    var kode_barang = $(this).attr("data-kode");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#text-total-"+id+"").text()))));
                                    var subtotal = harga * jumlah_baru;

                              
                                  $.post("update_data_stok_awal.php", {jumlah_baru:jumlah_baru,harga:harga,id:id}, function(info){


                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-total-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden");        
                                    
                                    
                                    });
                                    
                           

                                   
                                   $("#kode_barang").focus();

                                 });

                             </script>

<?php 
include 'footer.php';
 ?>