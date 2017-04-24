<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

<div class="container">
  <h1> Pengeluaran Per Tanggal</h1>

<form  id="perhari" role="form" method="post" action="hasil_pemasukan.php">

<div class="form-group">
    <label for="tanggal">Tanggal</label>
    <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" required="" autocomplete="off">
</div>

<div class="form-group">
    <label for="pengeluaran">Akun Pengeluaran</label>
    <select  type="text" class="form-control" id="ke_akun" name="ke_akun" placeholder="Kas" required="">
<option value="">-- Silakan Pilih --</option>
    <?php 

$pengeluaran = $db->query("SELECT * FROM pengeluaran");

    while($data_pengeluaran = mysqli_fetch_array($pengeluaran))
    {
    
    echo "<option>".$data_pengeluaran['nama'] ."</option>";

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
  var ke_akun = $("#ke_akun").val();

    $.post("hasil_pengeluaran.php" ,{tanggal:tanggal,ke_akun:ke_akun},function(data){


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
    $( "#tanggal" ).datepicker({ dateFormat: "yy-mm-dd"});
  });
</script> 
<!--end SCRIPT datepicker -->

