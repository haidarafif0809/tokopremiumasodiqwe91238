<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<style type="text/css">
  .hr{
    border: 0;
    border-top: 3px double #8c8c8c;
  }
</style>

<div class="container">
<h1>JURNAL UMUM </h1><hr>
<form id="perhari" class="form-inline" action="proses_laporan_jurnal.php" method="POST" role="form">
         
<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i> Tampil</button>
    
</form>
<br>
<span id="result" style="display: none">
  
  <div class="card card-block">



<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<table id="tableuser" class="table table-sm">
    <thead>
      <th style='background-color: #4CAF50; color: white' style="font-size: 20px"> No Akun </th>
      <th style='background-color: #4CAF50; color: white' style="font-size: 20px"> Nama Akun </th>
      <th style='background-color: #4CAF50; color: white' style="font-size: 20px"> Debet </th>
      <th style='background-color: #4CAF50; color: white' style="font-size: 20px"> Kredit </th>
      <th style='background-color: #4CAF50; color: white' style="font-size: 20px"> Keterangan </th>
    </thead>
    
  </table>
 </div>
  <br><br>

      

</div>   
</span>
</div> <!-- END DIV container -->



    <script type="text/javascript" language="javascript" >
      $(document).ready(function() {
$(document).on('click','#btntgl',function(e) {
     $('#tableuser').DataTable().destroy();

          var dataTable = $('#tableuser').DataTable( {
          "processing": true,
          "serverSide": true,
          "info":     true,
          "language": {
        "emptyTable":     "My Custom Message On Empty Table"
    },
          "ajax":{
            url :"proses_laporan_jurnal.php", // json datasource
             "data": function ( d ) {
                d.dari_tanggal = $("#daritgl").val();
                d.sampai_tanggal = $("#sampaitgl").val();
                // d.custom = $('#myInput').val();
                // etc
            },
                type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".tbody").html("");
              $("#tableuser").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
              $("#tableuser_processing").css("display","none");
              
            }
          }
    


        } );
          $("#result").show()

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

<?php 
include 'footer.php';
 ?>