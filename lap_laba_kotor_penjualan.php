<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h1> LAPORAN LABA KOTOR PENJUALAN </h1><hr>

<form id="perhari" class="form-inline" action="proses_laporan_laba_kotor.php" method="POST" role="form">
         
<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

<div class="form-group">
  <select name="jenis_laporan" id="jenis_laporan" class="form-control">
      <option value="1">Rekap</option> 
      <option value="2">Perproduk</option> 
  </select>
</div>

   
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i> Tampil</button>
    
</form>
<div class="card card-block" id="table-rekap" style="display:none">
      <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
        <span id="span_lap">
          <table id="tabel_lap" class="table table-bordered table-sm">
            <thead>
              
              <th  style="background-color: #4CAF50; color: white;"> Nomor Transaksi </th>
              <th  style="background-color: #4CAF50; color: white;"> Tanggal </th>
              <th  style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
              <th  style="background-color: #4CAF50; color: white;"> Sub Total </th>
              <th  style="background-color: #4CAF50; color: white;"> Total Pokok </th>
              <th  style="background-color: #4CAF50; color: white;"> Laba Kotor </th>
              <th  style="background-color: #4CAF50; color: white;"> Diskon Faktur </th>
              <th  style="background-color: #4CAF50; color: white;"> Laba Jual </th>        
            
            </thead>

          </table>
        </span>
      </div> <!--/ responsive-->

      <span id="cetak" style="display: none">
        <a href='cetak_laporan_laba_kotor.php' id="cetak_lap" class='btn btn-warning' target='blank'><i class='fa fa-print'> </i> Cetak Laporan</a>
      </span>
</div>

<div class="card card-block" id="table-perproduk" style="display:none">
      <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
        <span id="span_lap">
          <table id="tabelperproduk" class="table table-bordered table-sm">
            <thead>
              
              <th  style="background-color: #4CAF50; color: white;"> Kode Produk </th>
              <th  style="background-color: #4CAF50; color: white;"> Nama Produk </th>
              <th  style="background-color: #4CAF50; color: white;"> Jumlah Produk</th>
              <th  style="background-color: #4CAF50; color: white;"> Total Penjualan </th>
              <th  style="background-color: #4CAF50; color: white;"> Total HPP </th>
              <th  style="background-color: #4CAF50; color: white;"> Total Diskon</th>
              <th  style="background-color: #4CAF50; color: white;"> Total Laba</th> 
              <th  style="background-color: #4CAF50; color: white;"> %Laba </th>    
            
            </thead>

          </table>
        </span>
      </div> <!--/ responsive-->

      <span id="cetak_perproduk" style="display: none">
        <a href='' id="cetak_lap_perproduk" class='btn btn-warning' target='blank'><i class='fa fa-print'> </i> Cetak Laporan</a>
      </span>
</div>

</div> <!-- END DIV container -->



<script type="text/javascript">
$(document).ready(function() {
$(document).on('click','#btntgl',function(e){

     var sampai_tanggal = $("#sampaitgl").val();
     var dari_tanggal = $("#daritgl").val();
     var jenis_laporan = $("#jenis_laporan").val();
     
     if (jenis_laporan == 1) {// Rekap

                  $("#table-rekap").show();                  
                  $("#table-perproduk").hide();

                   $('#tabel_lap').DataTable().destroy();
                        var dataTable = $('#tabel_lap').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "info":     true,
                        "language": {
                        "emptyTable":     "My Custom Message On Empty Table"},
                        "ajax":{
                          url :"proses_laporan_laba_kotor.php", // json datasource
                           "data": function ( d ) {
                              d.dari_tanggal = $("#daritgl").val();
                              d.sampai_tanggal = $("#sampaitgl").val();
                              // d.custom = $('#myInput').val();
                              // etc
                          },
                              type: "post",  // method  , by default get
                          error: function(){  // error handling
                            $(".tbody_lap").html("");
                            $("#tabel_lap").append('<tbody class="tbody_lap"><tr><th colspan="3"></th></tr></tbody>');
                            $("#tabel_lap_processing").css("display","none");
                            
                       
                          }
                        }
                  
                  });

              $("#cetak").show();
              $("#cetak_lap").attr("href", "cetak_laporan_laba_kotor.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

     }
     else if(jenis_laporan == 2){ // perproduk

                  $("#table-perproduk").show();
                  $("#table-rekap").hide();

                   $('#tabelperproduk').DataTable().destroy();
                        var dataTable = $('#tabelperproduk').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "info":     true,
                        "language": {
                        "emptyTable":     "My Custom Message On Empty Table"},
                        "ajax":{
                          url :"proses_laporan_laba_kotor_perproduk.php", // json datasource
                           "data": function ( d ) {
                              d.dari_tanggal = $("#daritgl").val();
                              d.sampai_tanggal = $("#sampaitgl").val();
                              // d.custom = $('#myInput').val();
                              // etc
                          },
                              type: "post",  // method  , by default get
                          error: function(){  // error handling
                            $(".tabelperproduk").html("");
                            $("#tabelperproduk").append('<tbody class="tbody_lap"><tr><th colspan="3"></th></tr></tbody>');
                            $("#tabelperproduk_processing").css("display","none");
                            
                       
                          }
                        }
                  
                  });

              $("#cetak_perproduk").show();
              $("#cetak_lap_perproduk").attr("href", "cetak_laporan_laba_kotor_perproduk.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
     };

});

    $("#perhari").submit(function(){
      return false;
    });

    function clearInput(){
        $("#perhari :input").each(function(){
            $(this).val('');
        });
    };

});
//Ending untuk tampilkan table kas MUTASI MASUK detail
</script>
<!-- END Script Untuk Tampilan-->


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

<?php 
include 'footer.php';
 ?>