<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h1>LAPORAN MUTASI STOK</h1><hr>

<form id="perhari" class="form-inline" action="proses_laporan_mutasi_stok.php" method="POST" role="form">
         
<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i> Tampil</button>
    
</form>
<br>



<span id="result" style="display: none;">

<div class="card card-block">
  <div class="table-responsive">
    <table id="tabel_mutasi_stok" class="table table-bordered table-sm">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Kode Item </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nama Item </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Satuan </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Awal </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Awal </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Masuk </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Masuk </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Keluar </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Keluar </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Akhir </th>
            <th style='background-color: #4CAF50; color: white' style="font-size: 20px; text-align: center; "> Nilai Akhir </th>
        
        </thead> <!-- tag penutup tabel -->
  </table>
  </div>
</div>

</span>

<span id="cetak" style="display: none;">

  <a href='export_lap_mutasi_stok.php' target="blank" id="export_lap" class='btn btn-success'><i class='fa fa-download'> </i> Export Excel</a>

</span>

</div> <!-- END DIV container -->



<!-- START DATATABLE AJAX-->

<script type="text/javascript" language="javascript" >
  $(document).ready(function() {
  $(document).on('click','#btntgl',function(e) {
     $('#tabel_mutasi_stok').DataTable().destroy();

        var dari_tanggal = $("#daritgl").val();        
        var sampai_tanggal = $("#sampaitgl").val();

          var dataTable = $('#tabel_mutasi_stok').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_laporan_mutasi_stok.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tabel_mutasi_stok").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }   


        });
          $("#result").show();
          $("#cetak").show();

          $("#export_lap").attr("href", "export_lap_mutasi_stok.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

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
</script>
<!-- END DATATABLE AJAX-->


<!--SCRIPT datepicker -->
<script> 
  $(function() {
    $( ".dsds" ).datepicker({ dateFormat: "yy-mm-dd", beforeShow: function (input, inst) {
        var rect = input.getBoundingClientRect();
        setTimeout(function () {
         inst.dpDiv.css({ top: rect.top + 40, left: rect.left + 0 });
        }, 0);
    }
     });
  });
</script> 
<!--end SCRIPT datepicker -->

<?php 
include 'footer.php';
 ?>