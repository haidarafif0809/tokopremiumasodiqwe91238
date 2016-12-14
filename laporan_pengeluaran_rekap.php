<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h1>Laporan Pengeluaran Rekap</h1>

<form id="perhari" class="form-inline" action="tampil_cashflow.php" method="POST" role="form">
         
<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

    
<button id="btntgl" class="btn btn-primary"><span class="glyphicon glyphicon-eye-open"></span> Tampil</button>
    
</form>
<br>
<span id="result"></span>
</div> <!-- END DIV container -->

<!-- Script Untuk Tampilan-->
<script type="text/javascript">
$("#btntgl").click(function() {

      var dari_tanggal = $("#daritgl").val();
      var sampai_tanggal = $("#sampaitgl").val();

    $.post("hasil_pengeluaran_rekap.php" ,{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(data){


    $("#result").html(data); 

  });  
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
<!-- END Script Untuk Tampilan-->


<!--SCRIPT datepicker -->
<script> 
  $(function() {
    $( ".dsds" ).datepicker({ dateFormat: "yy-mm-dd" });
  });
</script> 
<!--end SCRIPT datepicker -->