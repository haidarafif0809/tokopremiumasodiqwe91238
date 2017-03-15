<?php include_once 'session_login.php';

include 'header.php';
include 'db.php';
 
$pilih_akses_tombol = $db->query("SELECT tombol_cash_drawer FROM otoritas_setting WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
$otoritas_tombol = mysqli_fetch_array($pilih_akses_tombol);

 ?>

<?php if ($otoritas_tombol['tombol_cash_drawer'] == 1): ?>

<script>
$(document).ready(function(){
  window.print();
});
</script>

<?php endif ?>