<?php include 'session_login.php';

include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

$pilih_akses = $db->query("SELECT program_promo_tambah, program_promo_edit, program_promo_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$program_promo = mysqli_fetch_array($pilih_akses);
?>

<script type="text/javascript">  
  $(function() {
    $("#batas_akhir").pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
</script>
<div class="container"><!-- START CONTAINER -->
  
  <h3>Program Promo Produk</h3><hr>

  <?php 
    if ($program_promo['program_promo_tambah'] > 0) {
      echo '<button class="btn btn-primary" id="tambah_program_promo" style="height:45px;" type="button" data-toggle="collapse" data-target="#collapsePromo" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"> </i> Program Promo </button>';
    }
  ?>

  <!--COLLAPSE -->
    <div class="collapse" id="collapsePromo">

        <form class="form-group" role="form" id="formprogram">

          <div class="row"><!--div class="row"-->
            
            <div class="col-sm-2"><!--/div class="col-sm-2"-->
                <label>Kode Program</label>
                <input type="text" name="kode_program" id="kode_program" autocomplete="off" class="form-control" style="height: 15px;"  placeholder="Kode Program">
            </div><!--div class="col-sm-2"-->

            <div class="col-sm-2"><!--/div class="col-sm-2"-->
                <label>Nama Program</label>
                <input type="text" name="nama_program" id="nama_program" autocomplete="off" class="form-control" style="height: 15px;"   placeholder="Nama Program">
            </div><!--div class="col-sm-2"-->

            <div class="col-sm-2"><!--/div class="col-sm-2"-->
                <label>Batas Akhir</label>
                <input type="text" name="batas_akhir" id="batas_akhir" autocomplete="off" class="form-control tanggal_cari" style="height: 15px;" placeholder="Batas Akhir">
            </div><!--div class="col-sm-2"-->

            <div class="col-sm-2"><!--/div class="col-sm-2"-->
                <label>Syarat ( Rp )</label>
                <input type="text" name="syarat_belanja" id="syarat_belanja" autocomplete="off" class="form-control" style="height: 15px;" onkeydown="return numbersonly(this, event);"  placeholder="Syarat Belanja">
            </div><!--div class="col-sm-2"-->

            <div class="col-sm-2"><!--/div class="col-sm-2"--><br>
                <select name="jenis_bonus" id="jenis_bonus" autocomplete="off" class="form-control chosen">
                  <option value="">Jenis Bonus</option>
                  <option value="Free Produk">Free Produk</option>
                  <option value="Disc Produk">Disc Produk</option>
                </select>
            </div><!--div class="col-sm-2"-->

            <div class="col-sm-2"><br>
              <button type="submit" id="tambah_program" class="btn btn-primary" style="background-color:#0277bd"><i class="fa fa-send"> </i> Submit</button>
            </div>

          </div><!--/div class="row"-->
   
        </form>

    </div>
  <!-- /COLLAPSE-->


  <!--DAFTAR PROGRAM PROMO --><br>
    <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
      <table id="table_program_promo" class="table table-bordered table-sm">
        <thead>
          <th style="background-color: #4CAF50; color: white;"> Kode Program</th>
          <th style="background-color: #4CAF50; color: white;"> Nama Program </th>
          <th style="background-color: #4CAF50; color: white;"> Batas Akhir </th>
          <th style="background-color: #4CAF50; color: white;"> Syarat Belanja </th>
          <th style="background-color: #4CAF50; color: white;"> Jenis Bonus </th>
          <th style="background-color: #4CAF50; color: white;"> Detail Program</th>
          <th style="background-color: #4CAF50; color: white;"> Detail Bonus </th>

            <?php 
              if ($program_promo['program_promo_hapus'] > 0) {
                echo '<th style="background-color: #4CAF50; color: white;"> Hapus </th>';
              }
            ?>
          
        </thead>
      </table>
    </div>

    <h6 style="text-align: left ; color: red"><i><b> * Klik 2x Pada Kolom Yang Akan Di Edit. </b></i></h6>

</div><!-- / CONTAINER -->

<script type="text/javascript">
  $(document).ready(function(){

      $('#table_program_promo').DataTable().destroy();

        var dataTable = $('#table_program_promo').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax":{
            url :"datatable_program_promo.php", // json datasource
            type: "post",  // method  , by default get
            error: function(){  // error handling
            $(".tbody").html("");
            $("#table_program_promo").append('<tbody class="tbody"><tr ><td colspan="3">No data found in the server</td></tr></tbody>');
            $("#table_ri_processing").css("display","none");
          }
        },

        "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                        $(nRow).attr('class','tr-id-'+aData[11]+'');
                },
                });
  });
</script>

<script type="text/javascript">
//pencegah kode program yang sama saat tambah
  $(document).ready(function(){
    $("#kode_program").blur(function(){

      var kode_program = $('#kode_program').val();

      $.post('cek_kode_program_promo.php',{kode_program:kode_program}, function(data){
        if(data == 1){
          alert("Kode Promo "+kode_program+" Sudah Ada, Silakan Gunakan Kode Yang lain !");
          $("#kode_program").val('');
          $("#kode_program").focus();
        }
      });

    });
  });     
</script>


<script type="text/javascript">
  $(document).ready(function(){
    $(document).on("click", "#tambah_program", function(){

     var kode_program = $("#kode_program").val();
     var nama_program = $("#nama_program").val();
     var batas_akhir = $("#batas_akhir").val();
     var syarat_belanja = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#syarat_belanja").val()))));
     var jenis_bonus = $("#jenis_bonus").val();
      if (kode_program == '') {
        alert("Silakan isikan kode program promo terlebih dahulu.");
        $("#kode_program").focus();
      }
      else if (nama_program == '') {
        alert("Silakan isikan nama program promo terlebih dahulu.");
        $("#nama_program").focus();
      }
      else if (batas_akhir == '') {
        alert("Silakan tentukan batas akhir program promo terlebih dahulu.");
        $("#batas_akhir").focus();
      }
      else if (syarat_belanja == '') {
        alert("Silakan tentukan syarat belanja terlebih dahulu.");
        $("#syarat_belanja").focus();
      }
      else if (jenis_bonus == '') {
        alert("Silakan tentukan jenis bonus terlebih dahulu.");
        $("#jenis_bonus").focus();
      }
      else
      {
          $("#tambh_program_promo").hide();
          $("#tambah_program_promo").show();
          $("#kode_program").val('');
          $("#nama_program").val('');
          $("#batas_akhir").val('');
          $("#syarat_belanja").val('');
          $("#jenis_bonus").val('');

        $.post("proses_program_promo.php",{kode_program:kode_program,nama_program:nama_program,batas_akhir:batas_akhir,syarat_belanja:syarat_belanja,jenis_bonus:jenis_bonus},function(info) {

          var table_program_promo = $('#table_program_promo').DataTable();
              table_program_promo.draw();

                 
        });
      }
      $("#formprogram").submit(function(){
      return false;
      }); 

    });
  });

</script>

<script type="text/javascript">
  $(document).on('click', '.delete', function (e) {
    var nama_program = $(this).attr("data-nama");
    var id = $(this).attr("data-id");
    var pesan_alert = confirm("Apakah Anda Yakin Ingin Menghapus Program "+nama_program+" ?");

      if (pesan_alert == true) {
        $.post("hapus_program_promo.php",{id:id},function(data){
              var table_program_promo = $('#table_program_promo').DataTable();
                  table_program_promo.draw();
        });
      }
      else{

      }
  });
</script>

<!-- EDIT TANGGAL -->
<script type="text/javascript">
  $(document).on('dblclick','.edit-tanggal',function(){
    var id = $(this).attr("data-id");

    $("#text-tanggal-"+id+"").hide();
    $("#input-tanggal-"+id+"").attr("type", "text");
  });

  $(document).on('blur','.input_tanggal',function(){
    var id = $(this).attr("data-id");
    var input_tanggal = $(this).val();
    var tanggal = input_tanggal;

      $.post("update_tanggal_program_promo.php",{id:id, input_tanggal:input_tanggal},function(data){

        $("#text-tanggal-"+id+"").show();
        $("#text-tanggal-"+id+"").text(tanggal);
        $("#input-tanggal-"+id+"").attr("type", "hidden");           

      });
  });
</script>
<!-- END EDIT TANGGAL -->

<!-- EDIT SYARAT -->
<script type="text/javascript">
  $(document).on('dblclick', '.edit-syarat', function (e) {
    var id = $(this).attr("data-id");

    $("#text-syarat-"+id).hide();
    $("#input-syarat-"+id).attr("type","text");
  });

  $(document).on('blur', '.edit_syarat', function (e) {
    var id = $(this).attr("data-id");
    var input_syarat = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).val()))));

      $.post("edit_syarat_belanja.php",{id:id, input_syarat:input_syarat},function(data){
        $("#text-syarat-"+id).text(tandaPemisahTitik(input_syarat));
        $("#text-syarat-"+id).show();
        $("#input-syarat-"+id).val(tandaPemisahTitik(input_syarat));
        $("#input-syarat-"+id).attr("type","hidden"); 
      });
  });
</script>
<!-- END EDIT SYARAT -->

<!-- EDIT NAMA PROGRAM -->
<script type="text/javascript">
  $(document).on('dblclick', '.edit-nama', function (e) {
    var id = $(this).attr("data-id");

    $("#text-nama-"+id).hide();
    $("#input-nama-"+id).attr("type","text");
  });

  $(document).on('blur', '.edit_nama', function (e) {
    var id = $(this).attr("data-id");
    var input_nama = $(this).val();

      $.post("edit_nama_program_promo.php",{id:id, input_nama:input_nama},function(data){
        $("#text-nama-"+id).text(input_nama);
        $("#text-nama-"+id).show();
        $("#input-nama-"+id).val(input_nama);
        $("#input-nama-"+id).attr("type","hidden"); 
      });
  });
</script>
<!-- END EDIT NAMA PROGRAM -->

<script type="text/javascript">
  $(document).on("dblclick",".edit-jenis",function(){
    var id = $(this).attr("data-id");

    $("#text-jenis-"+id+"").hide();
    $("#select-jenis-"+id+"").show();
  });

  $(document).on("blur",".select-jenis",function(){
    var id = $(this).attr("data-id");
    var select_jenis = $(this).val();

    $.post("update_jenis_bonus_program_promo.php",{id:id, select_jenis:select_jenis},function(data){

      $("#text-jenis-"+id+"").show();
      $("#text-jenis-"+id+"").text(select_jenis);
      $("#select-jenis-"+id+"").hide();

     var table_program_promo = $('#table_program_promo').DataTable();
         table_program_promo.draw();

    });
  });
</script>

<?php include 'footer.php'; ?>