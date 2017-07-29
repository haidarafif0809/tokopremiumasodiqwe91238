<?php


    $select_waktu_jatuh_tempo = $db->query("SELECT waktu FROM setting_waktu_reminder ");
    $data_jatuh_tempo = mysqli_fetch_array($select_waktu_jatuh_tempo);
    $jatuh_tempo = $data_jatuh_tempo['waktu'];
    $satu_menit = 60 * 1000;
    $waktu_jatuh_tempo = $satu_menit * $jatuh_tempo;

    $tanggal_sekarang = date('Y-m-d');

    $ambil_jatuh_tempo = $db->query("SELECT p.tanggal_jt, p.suplier, p.kredit, s.nama AS nama_suplier, p.no_faktur, p.tanggal, p.tanggal_jt FROM pembelian p INNER JOIN suplier s ON p.suplier = s.id WHERE p.kredit != '0' AND p.tanggal_jt = '$tanggal_sekarang'");
    $row_tanggal_jt = mysqli_num_rows($ambil_jatuh_tempo);
    

    $pilih_akses_peringatan = $db->query("SELECT peringatan_jatuh_tempo_hutang FROM otoritas_setting WHERE id_otoritas = '$_SESSION[otoritas_id]' ");
    $otoritas_peringatan = mysqli_fetch_array($pilih_akses_peringatan);

   
?>


<input type="hidden" id="waktu_jatuh_tempo" value="<?php echo $waktu_jatuh_tempo; ?>"/>
<input type="hidden" id="row_tanggal_jt" value="<?php echo $row_tanggal_jt; ?>"/>
<input type="hidden" id="session_print" value="<?php echo $_SESSION['printer']; ?>"/>

<button  type="button" style="display: none" id="btn-tampil-modal" value="Click Me" onclick="waktuReminder()" ></button>


<!-- Modal Tampilkan Produk yang promo -->
<div id="modal_reminder" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Peringatan/Reminider Hutang Jatuh Tempo Hari Ini</h4>
      </div>
      <div class="modal-body">
      
      <table id="table-hutang-jt" class="table table-hover table-sm">
      <thead>
            <th style='background-color: #4CAF50; color:white'"> Suplier</th>
            <th style='background-color: #4CAF50; color:white'"> No. Faktur</th>
            <th style='background-color: #4CAF50; color:white'"> Tanggal </th>
            <th style='background-color: #4CAF50; color:white'"> Tanggal JT</th>
            <th style='background-color: #4CAF50; color:white'"> Hutang </th>
      </thead>

      <tbody>

        <?php
          while ($tanggal_jt = mysqli_fetch_array($ambil_jatuh_tempo))
          {
          echo "<tr>
          <td>". $tanggal_jt['nama_suplier'] ."</td>
          <td>". $tanggal_jt['no_faktur'] ."</td>
          <td>". $tanggal_jt['tanggal'] ."</td>
          <td>". $tanggal_jt['tanggal_jt'] ."</td>
          <td>". $tanggal_jt['kredit'] ."</td>
          </tr>";
          }


        ?>
    
    </tbody>
</table>

      </div>
      <div class ="modal-footer">
        <button type ="button" id="btn-close" class="btn btn-default" value="close" >Close</button>
      </div>
  </div>

  </div>
</div><!-- end of modal buat data  -->


  


<script type="text/javascript">
  var session_print = $("#session_print").val();
  var row_tanggal_jt = $("#row_tanggal_jt").val();
  var waktu_jatuh_tempo = $("#waktu_jatuh_tempo").val();

  function tampilModal(){
    $('#modal_reminder').modal("show");
  }

  function waktuReminder(){
    reminderId = setInterval(tampilModal,waktu_jatuh_tempo);
  }

// Untuk menjalankan function waktuReminder
      <?php if ($otoritas_peringatan['peringatan_jatuh_tempo_hutang'] == 1): ?>
        if (session_print == 1 && row_tanggal_jt > 0) {
          waktuReminder();         
        }
      <?php endif ?>
        
</script>


<script type="text/javascript">

$(document).ready(function(){
  $(document).on('click','#btn-close',function(){
    var jatuh_tempo = <?php echo $jatuh_tempo ?>;

    var pesan_alert = confirm("Apakah Pengingat/Reminder Akan Ditampilkan "+jatuh_tempo+" Menit Lagi?");
    if (pesan_alert == true) {
      $("#modal_reminder").modal("hide");
    }
    else {
      $("#modal_reminder").modal('hide');
      $.get("destroy_session_printer.php",function(data){
        +$("#session_print").val(data);
      });
      clearInterval(reminderId);  
    }

  });
});

</script>

<!-- DATATABLE-->
<script type="text/javascript">
$(document).ready(function(){
    $('#table-hutang-jt').DataTable();
});
</script>