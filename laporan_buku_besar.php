<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
<h1> BUKU BESAR </h1><hr>


<form id="perhari" class="form-inline" action="proses_buku_besar.php" method="POST" role="form">
         
<div class="form-group">
    <input type="text" class="form-control dsds" id="daritgl" autocomplete="off" name="daritanggal" placeholder="Dari Tanggal ">
</div>

<div class="form-group">
    <input type="text" class="form-control dsds" id="sampaitgl" autocomplete="off" name="sampaitanggal" placeholder="Sampai Tanggal ">
</div>

<div class="form-group">

    <select  type="text" class="form-control chosen" id="daftar_akun" name="daftar_akun" required="">
    <option value=""> </option>
    <?php 

$ambil_kas = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun");

    while($data_kas = mysqli_fetch_array($ambil_kas))
    {
    
    echo "<option value='".$data_kas['kode_daftar_akun'] ."'>".$data_kas['nama_daftar_akun'] ."</option>";

    }

 //Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>
 </select>
</div>


<div class="form-group">

    <select  type="text" class="form-control" id="rekap" name="rekap">
    <option value="">--SILAKAN PILIH--</option>
    <option value="direkap_perhari"> Direkap Per Hari </option>
    <option value="tidak_direkap_perhari">Tidak Direkap Per Hari </option>
    </select>

</div>
    
<button id="btntgl" class="btn btn-primary"><i class="fa fa-eye"></i> Tampil</button>
    
</form>
<br>
<span id="result"></span>
</div> <!-- END DIV container -->

<!-- Script Untuk Tampilan-->
<script type="text/javascript">
$("#btntgl").click(function() {

      var dari_tanggal = $("#daritgl").val();
      var sampai_tanggal = $("#sampaitgl").val();
      var daftar_akun = $("#daftar_akun").val();
      var rekap = $("#rekap").val();

    $.post("proses_buku_besar.php" ,{dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal,daftar_akun:daftar_akun,rekap:rekap},function(data){


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
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});  
      
      </script>

      <?php 
      include 'footer.php';
       ?>