<?php include 'session_login.php';
//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">



<h1> LAPORAN 10 BESAR PENJUALAN</h1><hr>
<br>


<form id="perhari" class="form-inline"  method="POST" role="form">

<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i>Tampil</button>
    
</form>
<br>

<span id="result" style="display: none;">
<div class="card card-block">
<center><h2 style="display: none;" id="judul"></h2></center>
<br> <br>      
<div class="table-resposive">
    <table id="tabel_tampil" class="table table-striped">
        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
      <th  style='background-color: #4CAF50; color: white'> Kode Barang </th>
      <th  style='background-color: #4CAF50; color: white'> Nama Barang </th>
      <th  style='background-color: #4CAF50; color: white'> Satuan </th>
      <th  style='background-color: #4CAF50; color: white'> Penjualan Periode </th>
      <th  style='background-color: #4CAF50; color: white'> Penjualan Per Hari </th>
      <th  style='background-color: #4CAF50; color: white'> Stok </th>
        
        </thead> <!-- tag penutup tabel -->
  </table>
  </div>
<br>
    <div class="row">
        <div class="col-sm-2"><br>
          <a id="trx" href='' class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak</a>
        </div>  

         <div class="col-sm-2">
         <br>
        <a href='' style="width: 170px;" type='submit' id="btn-export" class='btn btn-default'><i class='fa fa-download'> </i> Download Excel</a>
        </div>

    </div>
</div>


</span>

</div> <!-- END DIV container -->



    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#btntgl',function(e) {


    var daritgl = $("#daritgl").val();
    var sampaitgl = $("#sampaitgl").val();

    if (daritgl == '') {
      alert("Dari tanggal harus di isi");
      $("#daritgl").focus();
    }
    else if (sampaitgl == '') {
      alert("Sampai tanggal harus di isi");
      $("#sampaitgl").focus();
    }
    else
    {
               $('#tabel_tampil').DataTable().destroy();



          var dataTable = $('#tabel_tampil').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     false,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_lap_jual_puluh_besar.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tabel_tampil").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tabel_tampil_processing").css("display","none");
              
            }
          }
    


        } );
          $("#result").show()

    }


   } );  
  $("#perhari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#perhari :input").each(function(){
          $(this).val('');
      });
  };
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



<!--untuk memasukkan perintah java script-->
<script type="text/javascript">

    $(document).on('click','#btntgl',function(e) {

   
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
        var dari_tanggal = $("#daritgl").val();
        var ambil_tgl1 = ambil_tgl(dari_tanggal);
        var ambil_bln1 = ambil_bln(dari_tanggal);
        var ambil_thn1 = ambil_thn(dari_tanggal);
        var tanggal1 = ambil_tgl1 + "/" + ambil_bln1 + "/" + ambil_thn1;

        var sampai_tanggal = $("#sampaitgl").val();
        var ambil_tgl2 = ambil_tgl(sampai_tanggal);
        var ambil_bln2 = ambil_bln(sampai_tanggal);
        var ambil_thn2 = ambil_thn(sampai_tanggal);
        var tanggal2 = ambil_tgl2 + "/" + ambil_bln2 + "/" + ambil_thn2;

        var judul = " Periode " + tanggal1 + " Sampai " + tanggal2;

          $("#judul").show();
          $("#judul").text(judul);
          $("#trx").attr('href','cetak_lap_jual_puluh_besar.php?dari_tanggal='+dari_tanggal+'&sampai_tanggal='+sampai_tanggal+"");
          $("#btn-export").attr("href","export_lap_jual_puluh_besar.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");

    });  

      $("#perhari").submit(function(){
      return false;
  });
  function clearInput(){
      $("#perhari :input").each(function(){
          $(this).val('');
      });
  };

  </script>


<?php 

include 'footer.php';
 ?>