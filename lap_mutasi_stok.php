<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h1>LAPORAN MUTASI STOK</h1><hr>

<form class="form-inline" role="form">
         
<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i> Tampil</button>
    
</form>

<span id="table_tampil" style="display: none;">
    <div class="card card-block">
      <div class="table-responsive">
       <table id="table_lap_mutasi_stok" class="table table-hover">
          <thead>
            <th style="text-align: center"> Kode Item </th>
            <th style="text-align: center"> Nama Item </th>
            <th style="text-align: center"> Satuan </th>
            <th style="text-align: center"> Awal </th>
            <th style="text-align: center"> Nilai Awal </th>
            <th style="text-align: center"> Masuk </th>
            <th style="text-align: center"> Nilai Masuk </th>
            <th style="text-align: center"> Keluar </th>
            <th style="text-align: center"> Nilai Keluar </th>
            <th style="text-align: center"> Akhir </th>
            <th style="text-align: center"> Nilai Akhir </th>
            
          </thead>

        </table>
      </div>
      <br>
       <br>

             <a href='cetak_laporan_mutasi_stok.php'
             id="cetak_lap" class='btn btn-warning' target='blank'><i class='fa fa-print'> </i> Cetak Laporan Mutasi Stok </a>
      </div>
</span>
<br>
<span id="result"></span>
</div> <!-- END DIV container -->


<!-- Script Untuk Tampilan-->
<script type="text/javascript">
$(document).on('click','#btntgl',function(e) {

      $('#table_lap_mutasi_stok').DataTable().destroy();
      var dari_tanggal = $("#daritgl").val();
      var sampai_tanggal = $("#sampaitgl").val();
          if (dari_tanggal == '') {
            alert("Silakan dari tanggal diisi terlebih dahulu.");
            $("#daritgl").focus();
          }
          else if (sampai_tanggal == '') {
            alert("Silakan sampai tanggal diisi terlebih dahulu.");
            $("#sampaitgl").focus();
          }
            else{
      $('#table_tampil').show();
          var dataTable = $('#table_lap_mutasi_stok').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_lap_mutasi_stok.php", // json datasource
            "data": function ( d ) {
                      d.dari_tanggal = $("#daritgl").val();
                      d.sampai_tanggal = $("#sampaitgl").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_mutasi_stok").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[11]+'');
            },

        });

        /*$.post("cek_total_lap_mutasi_stok.php",{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(data){

          $("#total_akhir").html(data);

        });*/


        $("#cetak").show();
      $("#cetak_lap").attr("href", "cetak_laporan_mutasi_stok.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
        }//end else
        $("form").submit(function(){
    return false;
});

    /*$.post("proses_laporan_mutasi_stok.php" ,{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(data){


    $("#result").html(data); 

  });  */
});



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
    }
     });
  });
</script> 
<!--end SCRIPT datepicker -->

<?php 
include 'footer.php';
 ?>