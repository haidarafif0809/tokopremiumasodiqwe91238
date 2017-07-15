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

<div class="container">


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

<div id="modal_detail_pembayaran_hutang" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail Pembayaran Hutang </h4>
      </div>

      <div class="modal-body">
      <div class="table-responsive">
      <span id="modal-detail-pembayaran-hutang"> </span>
      </div>

     </div>

      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"> Close</i></button>
      </div>
    </div>

  </div>
</div>
  <!-- Tampilan Modal DETAIL pembayaran hutang pembelian -->



  <!-- Tampilan Modal DETAIL retur pembelian -->

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
  <!-- Tampilan Modal DETAIL retur pembelian -->


  <!-- Tampilan Modal DETAIL pembelian -->

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
  </div><!-- END Tampilan Modal DETAIL pembelian -->
   <!-- END Tampilan Modal DETAIL pembelian -->
   <!-- END Tampilan Modal DETAIL pembelian -->
   <!-- END Tampilan Modal DETAIL pembelian -->



<h3>HISTORY SUPLIER</h3> <hr>


<form class="form-inline" role="form" id="form_tanggal">

<div class="form-group">
           <select style="font-size:15px; height:20px" type="text" name="suplier" id="suplier" class="form-control chosen" data-placeholder="SILAKAN PILIH...">
          <option value="">SILAKAN PILIH...</option>
             <?php 
 				$ambil_kategori = $db->query("SELECT id,nama FROM suplier");
                  
                  while($data_kategori = mysqli_fetch_array($ambil_kategori))
                            {
                                    
                             echo "<option value='".$data_kategori['id']."'>".$data_kategori['nama'] ."</option>";
                                    
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



<button type="submit" name="submit" id="lihat_history_suplier" class="btn btn-default" style="background-color:#0277bd"><i class="fa fa-eye"> </i> Lihat </button>
</form>


<div class="card card-block" >  <center><h2 style="display: none;" id="judul"></h2></center>


<div class="table-responsive">
    
    <table id="table-suplier" class="table table-bordered table-sm">

        <thead>

      <th style='background-color: #4CAF50; color:white'> Tanggal </th>
      <th style='background-color: #4CAF50; color:white'> Jenis Transaksi </th>
      <th style='background-color: #4CAF50; color:white'> No Faktur</th>
      <th style='background-color: #4CAF50; color:white'> No Faktur Terkait </th>
      <th style='background-color: #4CAF50; color:white'> Nilai Faktur</th>
      <th style='background-color: #4CAF50; color:white'> Pembayaran</th>
      <th style='background-color: #4CAF50; color:white'> Saldo Hutang</th>
      <th style='background-color: #4CAF50; color:white'> Detail</th>      
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


 <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#lihat_history_suplier',function(e) {

        var suplier = $("#suplier").val();      
        var daritgl = $("#daritgl").val();        
        var sampaitgl = $("#sampaitgl").val();
        if (suplier == '') {
          alert("Suplier Harus di isi");
           $("#suplier").focus();

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

     $('#table-suplier').DataTable().destroy();

          var dataTable = $('#table-suplier').DataTable( {
          "processing": true,
          "serverSide": true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"show_history_suplier.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                d.suplier = $("#suplier").val();  
                 // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#table-suplier").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#table-suplier_processing").css("display","none");
              
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
           $("#trx").attr("href",'cetak_history_sulier.php?daritgl='+daritgl+'&sampaitgl='+sampaitgl+'&suplier='+suplier);

          $("#judul").show();
          $("#judul").text(judul);
         
        }


          

   } );  

  $("form").submit(function(){
      return false;
  });

  } );
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
    $(document).on('click','.detail_pembelian',function(){

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

<!--menampilkan detail penjualan-->
<script type="text/javascript">
        
    $(document).on('click','.detail',function(e){
    var no_faktur_retur = $(this).attr('no_faktur_retur');
    
    
    $("#modal_detail").modal('show');
    
    $.post('detail_retur_pembelian.php',{no_faktur_retur:no_faktur_retur},function(info) {
    
    $("#modal-detail").html(info);
    
    
    });
    
    });
  
</script>



<script type="text/javascript">
$(document).on('click','.detail_pembayaran_hutang',function(e){
    var no_faktur_pembayaran = $(this).attr('no_faktur_pembayaran');
    
    
    $("#modal_detail_pembayaran_hutang").modal('show');
    
    $.post('proses_detail_pembayaran_hutang.php',{no_faktur_pembayaran:no_faktur_pembayaran},function(info) {
    
    $("#modal-detail-pembayaran-hutang").html(info);
    
    
    });
    
    });
</script>


<script type="text/javascript">
  //SELECT CHOSSESN    
$(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});   
</script>




<?php include 'footer.php'; ?>
