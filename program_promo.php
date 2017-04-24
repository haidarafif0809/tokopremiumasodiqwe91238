<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


$pilih_akses = $db->query("SELECT program_promo_tambah, program_promo_edit, program_promo_hapus FROM otoritas_master_data WHERE id_otoritas = '$_SESSION[otoritas_id]'");
$program_promo = mysqli_fetch_array($pilih_akses);


 ?>

<div class="container">

 <span id="judul">
   <h3><b>Program Promo Produk</b></h3><hr>
 </span>
 <span id="judul_edit" style="display: none;">
   <h3><b>Edit Promo Produk</b></h3><hr>
 </span>

<button style="display: none;" class="btn btn-primary" data-toggle="tooltip" accesskey="k" id="kembali" class="btn btn-primary" data-placement='top' title='Klik untuk kembali ke sebelumnya.'><i class="fa fa-reply"></i> <u>K</u>embali</button>

<?php 
  if ($program_promo['program_promo_tambah'] > 0) {
    echo '<button type="submit" id="tambah_program_promo" class="btn btn-success" style="background-color:#0277bd"><i class="fa fa-plus"> </i> Tambah</button>';
  }
 ?>
<span id="tambh_program_promo" style="display: none;"><!--span untuk TAMBAH-->
          <form class="form-inline" role="form" id="formprogram">
          <div class="row armun"><!--div class="row armun"-->
            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
              <div class="form-group"> 
                <input type="text" name="kode_program" id="kode_program" autocomplete="off" class="form-control" style="height: 5%; width: 95%;"  placeholder="Kode Program">
              </div>
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
                <input type="text" name="nama_program" id="nama_program" autocomplete="off" class="form-control" style="height: 5%; width: 95%;"   placeholder="Nama Program">
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
                <input type="text" name="batas_akhir" id="batas_akhir" autocomplete="off" class="form-control tanggal_cari" style="height: 5%; width: 95%;" placeholder="Kapan Berakhir?">
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
                <input type="text" name="syarat_belanja" id="syarat_belanja" autocomplete="off" class="form-control" style="height: 5%; width: 95%;" onkeydown="return numbersonly(this, event);"  placeholder="Syarat Belanja">
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"--><br>
                <select name="jenis_bonus" id="jenis_bonus" autocomplete="off" class="form-control" style="width: 75%;">
                  <option value="">Jenis Bonus</option>
                  <option value="Free Produk">Free Produk</option>
                  <option value="Disc Produk">Disc Produk</option>
                </select>
            </div><!--div class="col-sm-2 armun"-->
          </div><!--/div class="row armun"-->
   
          <button type="submit" id="tambah_program" class="btn btn-primary" style="background-color:#0277bd"><i class="fa fa-plus"> </i> Submit</button>
          </form>
        </span><!--Akhir span untuk TAMBAH-->

        <!--span untuk EDIT-->
        <span id="edit_program_promo" style="display: none;"><!--span untuk EDIT-->
          <form class="form-inline" role="form" id="formprogramedit">
          <div class="row armun"><!--div class="row armun"-->
            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
              <div class="form-group"> 
                <input type="text" name="kode_program_edit" id="kode_program_edit" autocomplete="off" class="form-control" readonly="" style="height: 5%; width: 95%;" readonly="" placeholder="Kode Program">
              </div>
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
                <input type="text" name="nama_program_edit" id="nama_program_edit" autocomplete="off" class="form-control" style="height: 5%; width: 95%;"   placeholder="Nama Program">
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
                <input type="text" name="batas_akhir_edit" id="batas_akhir_edit" autocomplete="off" class="form-control tanggal_cari" style="height: 5%; width: 95%;" placeholder="Kapan Berakhir?">
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"-->
                <input type="text" name="syarat_belanja_edit" id="syarat_belanja_edit" autocomplete="off" class="form-control" style="height: 5%; width: 95%;" onkeydown="return numbersonly(this, event);"  placeholder="Syarat Belanja">
            </div><!--div class="col-sm-2 armun"-->

            <div class="col-sm-2"><!--/div class="col-sm-2 armun"--><br>
                <select name="jenis_bonus_edit" id="jenis_bonus_edit" autocomplete="off" class="form-control" style="width: 75%;">
                  <option value="">Jenis Bonus</option>
                  <option value="Free Produk">Free Produk</option>
                  <option value="Disc Produk">Disc Produk</option>
                </select>

                <input type="hidden" name="id_edit" id="id_edit" autocomplete="off" class="form-control" style="height: 5%; width: 95%;" placeholder="id">
            </div><!--div class="col-sm-2 armun"-->
          </div><!--/div class="row armun"-->
   
          <button type="submit" id="submit_edit" class="btn btn-warning" style="background-color:#0277bd"><i class="fa fa-edit"> </i> Edit</button>
          </form>
        </span><!--Akhir span untuk EDIT-->


<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmsi Hapus Data</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Kode program :</label>
     <input type="text" id="kode_program_hapus" class="form-control" readonly=""> 
    </div>

    <div class="form-group">
    <label> Nama Program :</label>
     <input type="text" id="nama_program_hapus" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form> 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"><span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"><span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<br>
<span id="table_program">
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
      if ($program_promo['program_promo_edit'] > 0) {
        echo '<th style="background-color: #4CAF50; color: white;"> Edit </th>';
      }

     if ($program_promo['program_promo_hapus'] > 0) {
        echo '<th style="background-color: #4CAF50; color: white;"> hapus </th>';
      }
      ?>
      
    </thead>
  </table>
</div> <!--/ responsive-->
</span>

</div> <!--/ container-->

<!--====== AWAL TAMBAH========-->
<script type="text/javascript">
// MENAMPILKAN FORM
  $(document).ready(function(){
    $("#tambah_program_promo").click(function(){
      $("#tambh_program_promo").show();
      $("#tambah_program_promo").hide();
    });
  });
// /MENAMPILKAN FORM
</script>

<script type="text/javascript">
//pencegah kode program yang sama saat tambah
        $(document).ready(function(){
      // kode produk blur
        $("#kode_program").blur(function(){

          var kode_program = $('#kode_program').val();          

                $.post('cek_kode_program_promo.php',{kode_program:kode_program}, function(data){
            
              if(data == 1){
              alert("Kode Promo Sudah Ada, Silakan Gunakan Kode Yang lain !");
              $("#kode_program").val('');
              $("#kode_program").focus();
              }//penutup if
              
              });////penutup function(data)

        }); //end kkode produk blur

        // kode produk mouseleave 
        $("#kode_program").mouseleave(function(){

          var kode_program = $('#kode_program').val();          

                $.post('cek_kode_program_promo.php',{kode_program:kode_program}, function(data){
            
              if(data == 1){
              alert("Kode Promo Sudah Ada, Silakan Gunakan Kode Yang lain !");
              $("#kode_program").val('');
              $("#kode_program").focus();
              }//penutup if
              
              });////penutup function(data)

        });//end kodeproduk mouseleave

        });     
</script>



<script type="text/javascript">
// MENAMPILKAN FORM
  $(document).ready(function(){
    $("#tambah_program").click(function(){

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
        $.post("proses_program_promo.php",{kode_program:kode_program,nama_program:nama_program,batas_akhir:batas_akhir,syarat_belanja:syarat_belanja,jenis_bonus:jenis_bonus},function(info) {
          $("#tambh_program_promo").hide();
          $("#tambah_program_promo").show();

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

                 $("#kode_program").val('');
       $("#nama_program").val('');
       $("#batas_akhir").val('');
       $("#syarat_belanja").val('');
       $("#jenis_bonus").val('');
       });
      }
      $("#formprogram").submit(function(){
      return false;
      }); 

    });// end $("#tambh_program_promo").click(function()
  });// end $(document).ready(function()

// /MENAMPILKAN FORM
</script>
<!--=====AKHIR TAMBAH-->

<!--=====AWAL EDIT =====-->

<script type="text/javascript">
        $(document).ready(function(){
        $("#kembali").click(function(){

          $("#kembali").hide();
          $("#edit_program_promo").hide();
          $("#judul_edit").hide();
          $("#tambh_program_promo").hide();
          $("#judul").show();
          $("#table_program").show();
          $("#tambah_program_promo").show();
        });
        });     
</script>

<script type="text/javascript">
    $(document).ready(function(){
    // Tooltips Initialization
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    });
    });
</script>

<!--script type="text/javascript">
//pencegah kode program yang sama  saat edit
        $(document).ready(function(){
        $("#kode_program_edit").blur(function(){

          var kode_program = $('#kode_program_edit').val();          

                $.post('cek_kode_program_promo.php',{kode_program:kode_program}, function(data){
            
              if(data == 1){
              alert("Kode Promo Sudah Ada, Silakan Gunakan Kode Yang lain !");
              $("#kode_program_edit").focus();
              $("#id_edit").val('');
              }//penutup if
              
              });////penutup function(data)

        });

        });     
</script-->

<script type="text/javascript">
// MENAMPILKAN FORM EDIT
  $(document).ready(function(){
    $(document).on('click', '.edit', function (e) {
      
     var kode_program_edit = $(this).attr("data-kode");
     var nama_program_edit = $(this).attr("data-nama");
     var batas_akhir_edit = $(this).attr("data-batas");
     var syarat_belanja_edit = $(this).attr("data-syarat");
     var jenis_bonus_edit = $(this).attr("data-jenis");
     var id_edit = $(this).attr("data-id");

     $("#kode_program_edit").val(kode_program_edit);
     $("#nama_program_edit").val(nama_program_edit);
     $("#batas_akhir_edit").val(batas_akhir_edit);
     $("#syarat_belanja_edit").val(syarat_belanja_edit);
     $("#jenis_bonus_edit").val(jenis_bonus_edit);
     $("#id_edit").val(id_edit);

      $("#kembali").show();
      $("#edit_program_promo").show();
      $("#judul_edit").show();
      $("#tambh_program_promo").hide();
      $("#judul").hide();
      $("#table_program").hide();
      $("#tambah_program_promo").hide();

    });
//==========
    $("#submit_edit").click(function(){

    var kode_program = $("#kode_program_edit").val();
     var nama_program = $("#nama_program_edit").val();
     var batas_akhir = $("#batas_akhir_edit").val();
     var syarat_belanja = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#syarat_belanja_edit").val()))));
     var jenis_bonus = $("#jenis_bonus_edit").val();
     var id = $("#id_edit").val();
      if (kode_program == '') {
        alert("Silakan isikan kode program promo terlebih dahulu.");
        $("#kode_program_edit").focus();
      }
      else if (nama_program == '') {
        alert("Silakan isikan nama program promo terlebih dahulu.");
        $("#nama_program_edit").focus();
      }
      else if (batas_akhir == '') {
        alert("Silakan tentukan batas akhir program promo terlebih dahulu.");
        $("#batas_akhir_edit").focus();
      }
      else if (syarat_belanja == '') {
        alert("Silakan tentukan syarat belanja terlebih dahulu.");
        $("#syarat_belanja_edit").focus();
      }
      else if (jenis_bonus == '') {
        alert("Silakan tentukan jenis bonus terlebih dahulu.");
        $("#jenis_bonus_edit").focus();
      }
      else
      {
        $.post("edit_program_promo.php",{id:id,kode_program:kode_program,nama_program:nama_program,batas_akhir:batas_akhir,syarat_belanja:syarat_belanja,jenis_bonus:jenis_bonus},function(info) {
          $("#tambh_program_promo").hide();
          $("#tambah_program_promo").show();
          $("#table_program").show();
          $("#kembali").hide();
          $("#judul_edit").hide();
          $("#edit_program_promo").hide();
          $("#judul").show();

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

                 $("#kode_program_edit").val('');
       $("#nama_program_edit").val('');
       $("#batas_akhir_edit").val('');
       $("#syarat_belanja_edit").val('');
       $("#jenis_bonus_edit").val('');
       });
      }
      $("#formprogramedit").submit(function(){
      return false;
      }); 

    });// end $("#tambh_program_promo").click(function()
  });// end $(document).ready(function()
// /MENAMPILKAN FORM EDIT
</script>
<!--=====AKHIR EDIT =====-->

<script type="text/javascript">
  //fungsi hapus data 
$(document).on('click', '.delete', function (e) {
    var kode = $(this).attr("data-kode");
    var nama = $(this).attr("data-nama");
    var id = $(this).attr("data-id");
    $("#kode_program_hapus").val(kode);
    $("#nama_program_hapus").val(nama);
    $("#id_hapus").val(id);
    $("#modal_hapus").modal('show');
    
    $(document).on('click', '#btn_jadi_hapus', function (e) {
    
    var id = $("#id_hapus").val();
    $.post("hapus_program_promo.php",{id:id},function(data){
    if (data != "") {
    
    $("#modal_hapus").modal('hide');

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
    }

    });
    
    });

    });
</script>


<script type="text/javascript">
//PICKERDATE
  $(function() {
  $( ".tanggal_cari" ).pickadate({ selectYears: 100, format: 'yyyy-mm-dd'});
  });
  // /PICKERDATE
</script>

<!--DATA TABLE MENGGUNAKAN AJAX-->
<script type="text/javascript" language="javascript" >
      $(document).ready(function() {

          var dataTable = $('#table_program_promo').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_program_promo.php", // json datasource
           
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_program_promo").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[9]+'');
            },
        });

        $("form").submit(function(){
        return false;
        });
        

      } );
</script>


<?php include 'footer.php'; ?>