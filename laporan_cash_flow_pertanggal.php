<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
  <h1> Cashflow Per Tanggal</h1>

<form  id="perhari" role="form" method="post" action="hasil_cashflow.php">

<div class="form-group">
    <label for="tanggal">Tanggal</label>
    <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" required="" autocomplete="off">
</div>

<div class="form-group">
    <label for="kas">Kas</label>
    <select  type="text" class="form-control" id="cara_bayar" name="cara_bayar" placeholder="Kas" required="">
<option value="">-- Silakan Pilih --</option>
    <?php 

$query = $db->query("SELECT id, kode_daftar_akun, nama_daftar_akun FROM daftar_akun WHERE tipe_akun = 'Kas & Bank' ");

    while($data_kas = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data_kas['kode_daftar_akun'] ."'>".$data_kas['nama_daftar_akun'] ."</option>";

    }

//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>
 </select>
</div>

<button  id="btnTambah" type="submit"  class="btn btn-primary"> <span class="glyphicon glyphicon-eye-open"></span> Tampil </button>
</form>


<br>

<span id="result"></span>

</div> <!-- container div -->



<!-- script tampilan  -->
<script type="text/javascript">
$("#btnTambah").click(function() {
  var tanggal = $("#tanggal").val();
  var cara_bayar = $("#cara_bayar").val();

    $.post("hasil_cashflow.php" ,{tanggal:tanggal,cara_bayar:cara_bayar},function(data){


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
<!-- end script tampilan -->

<!--SCRIPT datepicker -->
<script> 
  $(function() {
    $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
  });
</script> 
<!--end SCRIPT datepicker -->

