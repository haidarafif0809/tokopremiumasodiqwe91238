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

    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i> Tampil</button>
    
</form>
<div class="card card-block">
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

</div> <!-- END DIV container -->



<script type="text/javascript">
$(document).ready(function() {
$(document).on('click','#btntgl',function(e){


     var sampai_tanggal = $("#sampaitgl").val();
     var dari_tanggal = $("#daritgl").val();  
     


  //untuk tampilkan table kas MUTASI MASUK detail
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