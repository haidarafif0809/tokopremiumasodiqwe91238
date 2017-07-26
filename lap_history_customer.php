<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->


<!-- Modal Hapus data -->
<div id="modal_hapus_pp" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Pembayaran Piutang</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Pelanggan :</label>
     <input type="text" id="pelanggan_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 

     <input type="hidden" id="no_faktur_hapus" class="form-control" readonly=""> 
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




<!-- Modal Hapus data -->
<div id="modal_hapus_retur" class="modal fade" role="dialog">
  <div class="modal-dialog">



    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Retur Penjualan</h4>
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

<div id="modal_alert-retur" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 style="color:orange" class="modal-title"><span class="glyphicon glyphicon-info-sign">Info</span></h3>
        
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-alert-retur">
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

<!-- Modal Hapus data -->
<div id="modal_hapus_jual" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Penjualan</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label>Kode Pelanggan :</label>
     <input type="text" id="kode_pelanggan" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
     <input type="hidden" id="kode_meja" class="form-control" > 
     <input type="text" id="faktur_hapus" class="form-control" > 
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


<div class="container">

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





<!--tampilan modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">

    <!-- isi modal-->
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><b>Data Barang</b></center></h4>
      </div>
      <div class="modal-body">
      <center>
          <div class="table-responsive">    
            <table id="table-modal" class="table table-bordered table-sm">
              <thead>
                <th> Kode Barang </th>
                <th> Nama Barang </th>
                <th> Jumlah Barang </th>
                <th> Satuan </th>
                <th> Kategori </th>
                <th> Status </th>
              </thead>
            </table>
          </div>
      </center>
      </div> <!-- tag penutup modal-body-->
      <div class="modal-footer">
        <center><b><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div></b></center>
    </div>

  </div>
</div>
<!-- end of modal data barang  -->


  <!-- Tampilan Modal DETAIL pembayaran hutang pembelian -->

<div id="modal_detailpiutang" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Pembayaran Piutang </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detailpiutang"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>




<div id="modal_detail_retur" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Retur Penjualan </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail-retur"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


  <!-- Tampilan Modal DETAIL pembelian -->

  <div id="modal_detail_jual" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><center><h4><b>Detail Penjualan</b></h4></center></h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail"> </span>

       
  <table id="table_modal_detail" class="table table-bordered table-sm">
  <thead> <!-- untuk memberikan nama pada kolom tabel -->

          <th> No Faktur </th>
          <th> Kode Barang </th>
          <th> Nama Barang </th>
          <th> Jumlah Barang </th>
          <th> Satuan </th>
          <th> Harga </th>
          <th> Potongan </th>
          <th> Tax </th>
          <th> Subtotal </th>

  </thead> <!-- tag penutup tabel -->
  </table>


      </div>

     </div>

      <div class="modal-footer">
        
  <center><button type="button" class="btn btn-primary" data-dismiss="modal">Close</button></center>
      </div>
    </div>

  </div>
</div>

   <!-- END Tampilan Modal DETAIL pembelian -->

<h3>HISTORY CUSTOMER</h3> <hr>


<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group">
           <select style="font-size:15px; height:20px" type="text" name="pelanggan" id="pelanggan" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
          <option value="">SILAKAN PILIH...</option>
             <?php 
 				$ambilpelanggan = $db->query("SELECT id,kode_pelanggan, nama_pelanggan FROM pelanggan");
                  
                  while($datapelanggan = mysqli_fetch_array($ambilpelanggan))
                            {
                                    
                             echo "<option value='".$datapelanggan['id']."'>".$datapelanggan['kode_pelanggan'] ." || ".$datapelanggan['nama_pelanggan'] ."</option>";
                                    
                            }

              ?>
      </select>
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">


</div>



<button type="submit" name="submit" id="lihat_history_customer" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>


<div class="card card-block" style="display: none" id="card-block">  <center><h2 style="display: none;" id="judul"></h2></center>


<div class="table-responsive">
    
    <table id="table-pelanggan" class="table table-bordered table-sm">

        <thead>

      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jenis Transaksi </th>
      <th style='background-color: #4CAF50; color:white'> No Faktur</th>
      <th style='background-color: #4CAF50; color:white'> No Faktur Terkait </th>
      <th style='background-color: #4CAF50; color:white'> Nilai Faktur</th>
      <th style='background-color: #4CAF50; color:white'> Pembayaran</th>
      <th style='background-color: #4CAF50; color:white'> Saldo Piutang</th>
      <th style='background-color: #4CAF50; color:white'> Detail</th> 
      <th style='background-color: #4CAF50; color:white'> Edit</th>
      <th style='background-color: #4CAF50; color:white'> Hapus</th>     
           </thead>

     </table>

</div>



  <div class="row">
          <a id="trx" href='' class='btn btn-success' style="display: none;" target='blank'><i class='fa fa-print'> </i> Cetak</a>
        
    </div>


</div>


</div>

  </span>



</div><!--Div Container-->

<script>
//Choosen Open select
$(document).ready(function(){
    $("#pelanggan").trigger('chosen:open');

});
</script>

 <script type="text/javascript" language="javascript" >
$(document).on('click','#lihat_history_customer',function(e) {

        var pelanggan = $("#pelanggan").val();      
        var daritgl = $("#daritgl").val();        
        var sampaitgl = $("#sampaitgl").val();
        if (pelanggan == '') {
          alert("pelanggan Harus di isi");
           $("#pelanggan").focus();

        }
        else if (daritgl == '') {
          alert("Dari Tanggal Harus di isi");
           $("#daritgl").focus();
        }
       else if (sampaitgl == '') {
          alert("Sampai Tanggal Harus di isi");
           $("#sampaitgl").focus();
        }
        else
        {

      $("#card-block").show();
     $('#table-pelanggan').DataTable().destroy();

          var dataTable = $('#table-pelanggan').DataTable( {
          "processing": true,
          "serverSide": true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"show_history_customer.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                d.pelanggan = $("#pelanggan").val();  
                 // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-pelanggan").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table-pelanggan_processing").css("display","none");
              
            }
          }
    


        } );
        $("#result").show()


       function ambil_tgl(tanggal_input1){
        var birthday1 = tanggal_input1;
        birthday1=birthday1.split("-");   
        var hari_ini = birthday1[2];
        return hari_ini;
        }
        function ambil_bln(tanggal_input2){
        var birthday2 = tanggal_input2;
        birthday2=birthday2.split("-");   
        var bulan = birthday2[1];
        return bulan;
        }

        function ambil_thn(tanggal_input3){
        var birthday3 = tanggal_input3;
        birthday3=birthday3.split("-");   
        var tahun = birthday3[0];
        return tahun;
        }
        var ambil_tgl1 = ambil_tgl(daritgl);
        var ambil_bln1 = ambil_bln(daritgl);
        var ambil_thn1 = ambil_thn(daritgl);
        var tanggal1 = ambil_tgl1 + "-" + ambil_bln1 + "-" + ambil_thn1;

        var ambil_tgl2 = ambil_tgl(sampaitgl);
        var ambil_bln2 = ambil_bln(sampaitgl);
        var ambil_thn2 = ambil_thn(sampaitgl);
        var tanggal2 = ambil_tgl2 + "-" + ambil_bln2 + "-" + ambil_thn2;

        var judul = "Periode " + tanggal1 + " Sampai " + tanggal2;


           $("#trx").show();
           $("#trx").attr("href",'cetak_history_customer.php?daritgl='+daritgl+'&sampaitgl='+sampaitgl+'&pelanggan='+pelanggan);

          $("#judul").show();
          $("#judul").text(judul);
         
        }


          

   } );  

  $("form").submit(function(){
      return false;
  });
</script>


<!--SCRIPT datepicker -->
<script> 
  $(function() {
    $( ".dsds" ).datepicker({ dateFormat: "yy-mm-dd", beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
         inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
        }, 0);
    } });
  });
</script> 
<!--end SCRIPT datepicker -->
  
<script type="text/javascript">
  $(document).ready(function(){
    $(document).on('click','.detail_penjualan',function(){
       $("#modal_detail_jual").modal('show');

        var no_faktur = $(this).attr("no_faktur");
        $('#table_modal_detail').DataTable().destroy();

        var dataTable = $('#table_modal_detail').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"modal_detail_penjualan.php", // json datasource
             "data": function ( d ) {
                  d.no_faktur = no_faktur;
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

<!--menampilkan detail penjualan-->
<script type="text/javascript">
        
    $(document).on('click','.detail_retur_penjualan',function(e){
    var no_faktur_retur = $(this).attr('no_faktur_retur');
    
    
    $("#modal_detail_retur").modal('show');
    
    $.post('detail_retur_penjualan.php',{no_faktur_retur:no_faktur_retur},function(info) {
    
    $("#modal-detail-retur").html(info);
    
    
    });
    
    });
  
</script>



<script type="text/javascript">
$(document).on('click','.detail_pembayaran_piutang',function(e){
 
    var no_faktur_pembayaran = $(this).attr('no_faktur_pembayaran');
    
    
    $("#modal_detailpiutang").modal('show');
    
    $.post('detail_pembayaran_piutang.php',{no_faktur_pembayaran:no_faktur_pembayaran},function(info) {
    
    $("#modal-detailpiutang").html(info);
    
    
    });
    
    });
</script>

<!--Tombol edit dan hapus pertransaksi-->


<script type="text/javascript">
  
    $(document).on('click', '.btn-alert-jual', function (e) {
    var no_faktur = $(this).attr("data-faktur");

    $.post('modal_retur_piutang.php',{no_faktur:no_faktur},function(data){


    $("#modal_alert").modal('show');
    $("#modal-alert").html(data);

    });

    
    });

</script>

<script type="text/javascript">
  
    $(document).on('click', '.btn-alert-retur', function (e) {
    var no_faktur = $(this).attr("data-faktur");

    $.post('modal_alert_hapus_data_retur_penjualan.php',{no_faktur:no_faktur},function(data){


    $("#modal_alert-retur").modal('show');
    $("#modal-alert-retur").html(data);

    });

    
    });

</script>


<!--Tombol edit dan hapus pertransaksi-->


  <script type="text/javascript">
      $(document).ready(function(){
//fungsi hapus data

    $(document).on('click', '.btn-hapus-jual', function (e) {
    var kode_pelanggan = $(this).attr("data-pelanggan");
    var id = $(this).attr("data-id");
    var no_faktur = $(this).attr("data-faktur");
    var kode_meja = $(this).attr("kode_meja");


    $("#kode_pelanggan").val(kode_pelanggan);
    $("#id_hapus").val(id);
    $("#faktur_hapus").val(no_faktur);
    $("#kode_meja").val(kode_meja);

    $("#modal_hapus_jual").modal('show');
    $("#btn_jadi_hapus").attr("data-id", id);
    
    
    });
    
    $("#btn_jadi_hapus").click(function(){
    
    
    var id = $(this).attr("data-id");
    var no_faktur = $("#faktur_hapus").val();
    var kode_meja = $("#kode_meja").val();
    
    
    
    $("#modal_hapus_jual").modal('hide');

    $.post("hapus_data_penjualan.php",{id:id,no_faktur:no_faktur,kode_meja:kode_meja},function(data){


      var table_pelanggan = $('#table-pelanggan').DataTable();
          table_pelanggan.draw();
    
    });
    
    
    });




            $('form').submit(function(){
            
            return false;
            });
});

    </script>


      <script type="text/javascript">
        
        //fungsi hapus data 
        $(document).on('click', '.btn-hapus-retur', function (e) {
        var kode_pelanggan = $(this).attr("data-pelanggan");
        var no_faktur_retur = $(this).attr("data-faktur");
        var id = $(this).attr("data-id");
        $("#data_pelanggan").val(kode_pelanggan);
        $("#hapus_faktur").val(no_faktur_retur);
        $("#id_hapus").val(id);
        $("#modal_hapus_retur").modal('show');
        $("#btn_jadi_hapus").attr("data-id", id);
        
        
        });
        
        $(document).on('click', '#btn_jadi_hapus', function (e) {
        
        
        var id = $(this).attr("data-id");
        var no_faktur_retur = $("#hapus_faktur").val();

        $.post("hapus_data_retur_penjualan.php",{id:id, no_faktur_retur:no_faktur_retur},function(data){
        if (data != "") {
        
        $("#modal_hapus_retur").modal('hide');
        $(".tr-id-"+id).remove();
        
        }
        
        });
        
        
        });
        
        
        </script>


 <script type="text/javascript">
      
//fungsi hapus data 
    $(document).on('click','.btn-hapus-pp',function(e){
    var pelanggan = $(this).attr("data-pelanggan");
    var id = $(this).attr("data-id");
    var no_faktur_pembayaran = $(this).attr("data-no-faktur");


    $("#no_faktur_hapus").val(no_faktur_pembayaran);
    $("#pelanggan_hapus").val(pelanggan);
    $("#id_hapus").val(id);
    $("#modal_hapus_pp").modal('show');
    $("#btn_jadi_hapus").attr("data-id", id);
    
    
    });


    $("#btn_jadi_hapus").click(function(){
    
    var id = $(this).attr("data-id");
    var no_faktur_pembayaran = $("#no_faktur_hapus").val();

    $.post("hapus_data_pembayaran_piutang.php",{id:id, no_faktur_pembayaran:no_faktur_pembayaran},function(data){
    if (data != "") {

    $("#modal_hapus_pp").modal('hide');
    $(".tr-id-"+id).remove();
    
    }

    
    });
    
    
    });

    </script>

<script type="text/javascript">
  //SELECT CHOSSESN    
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});   
</script>




<?php include 'footer.php'; ?>
