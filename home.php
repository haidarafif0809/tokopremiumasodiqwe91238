<?php 

//memasukkan file session login, db, header, navbar.php
include 'session_login.php';
include 'db.php';
include 'header.php';
include 'navbar.php';


 ?>

 <center> <img src="save_picture/andaglos_logo.png" class="img-responsive" width="500" height="160"> </center>
 <center> <img src="save_picture/home.png" class="img-responsive" width="800" height="800"> </center>

<!-- AGAR SAAT LOGIN LANGSUNG MUNCUL PERINGTAN JATUH TEMPO HUTANG -->
<script type="text/javascript">
$(document).ready(function(){
  var session_print = $("#session_print").val();
  var row_tanggal_jt = $("#row_tanggal_jt").val();

// Untuk membuka modal reminder
      <?php if ($otoritas_peringatan['peringatan_jatuh_tempo_hutang'] == 1): ?>
        if (session_print == 1 && row_tanggal_jt > 0) {
             $('#modal_reminder').modal("show");   
        }
      <?php endif ?>
});     
</script>
<!-- AGAR SAAT LOGIN LANGSUNG MUNCUL PERINGTAN JATUH TEMPO HUTANG -->

<?php 
include 'footer.php';
 ?>