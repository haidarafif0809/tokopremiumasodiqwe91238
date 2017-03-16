<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';
 include 'sanitasi.php';

$no_faktur = stringdoang($_GET['no_faktur']);

$select_tanggal = $db->query("SELECT DATE(waktu_jurnal) AS tanggal,keterangan_jurnal FROM jurnal_trans WHERE no_faktur = '$no_faktur'");
$ambil_tanggal = mysqli_fetch_array($select_tanggal);

$tanggal = $ambil_tanggal['tanggal'];
$keterangan = $ambil_tanggal['keterangan_jurnal'];



$tahun_sekarang = date('Y');
$bulan_sekarang = date('m');
$tanggal_sekarang = date('Y-m-d');
$jam_sekarang = date('H:i:sa');
$tahun_terakhir = substr($tahun_sekarang, 2);




 ?>

      <script>
  $(function() {
    $( "#tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
  });
  </script>

<div class="container">

<h3> Edit Transaksi Jurnal Manual </h3>
<br><br>


<div class="card card-block"> 

<form role="form" method="post" id="formtambahproduk">
<div class="row">

          <div class="form-group col-sm-3">
          <label> Tanggal </label><br>
          <input type="text" name="tanggal" id="tanggal" placeholder="Tanggal" value="<?php echo $tanggal; ?>" class="form-control" required="" >
          </div>

          <div class="form-group col-sm-3">
          <label> No Faktur </label><br>
          <input type="text" name="no_faktur" id="no_faktur" class="form-control" readonly="" value="<?php echo $no_faktur; ?>" required="" >
          </div>

          <div class="form-group col-sm-3">
          <label> Jenis </label><br>
          <input type="text" name="jenis" autocomplete="off" id="jenis" value="Jurnal Manual" class="form-control" readonly="">
          </div>

          <div class="form-group col-sm-3">
          <label> Keterangan </label><br>
          <input type="text" name="keterangan" autocomplete="off" id="keterangan" value="<?php echo $keterangan; ?>" placeholder="Keterangan" class="form-control">
          </div>

</div> <!-- tag penutup div row -->




<div class="row">

          <div class="form-group col-sm-3">
          
          <label> Kode Akun </label>
          <br>
          <br>
          <select type="text" name="kode_akun" id="kode_akun" class="form-control chosen" >
          <option value="">--SILAHKAN PILIH--</option>

      <?php 

    
    $query = $db->query("SELECT kode_daftar_akun, nama_daftar_akun FROM daftar_akun ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['kode_daftar_akun']."'>".$data['kode_daftar_akun'] ." || ".$data['nama_daftar_akun']."</option>";
    }
    
    
    ?>
            </select>
          </div>

          
          <div class="form-group col-sm-3">
          <label> Nama Akun </label><br>
          <input type="text" name="nama_akun" id="nama_akun" autocomplete="off" placeholder="Nama Akun" class="form-control"  readonly="">
          </div>


          <div class="form-group col-sm-2">
          <label> Debit </label><br>
          <input type="text" name="debit" id="debit" autocomplete="off" placeholder="Debit" class="form-control"  >
          </div>

          <div class="form-group col-sm-2">
          <label> Kredit </label><br>
          <input type="text" name="kredit" id="kredit" autocomplete="off" placeholder="Kredit" class="form-control"  >
          </div>

          <div class="form-group col-sm-2">
          <br>
          <br>
          <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah </button>
          </div>

          
          
          
</div> <!-- tag penutup div row-->

</form>

</div><!--penutup div card block-->

  <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
  <div class="alert alert-success" id="alert_berhasil" style="display:none">
  <strong>Success!</strong> Data Kas Masuk Berhasil
</div>

      <span id="result">  
      
        <div class="table-responsive">
      <!--tag untuk membuat garis pada tabel-->     
  <table id="table_jurnal_tbs" class="table table-bordered table-sm">
    <thead>
      <th> Kode Akun </th>
      <th> Nama Akun </th>
      <th> Debit </th>      
      <th> Kredit </th>      
      <th> Hapus </th> 
      
    </thead>
  </table>

  
  <h6 style="text-align: left ; color: red"><i> * Klik 2x pada kolom Debit atau Kredit jika ingin mengedit.</i></h6>
  </div>
        </span>

<br><br>


<div class="row">

          <div class="form-group col-sm-6">
          </div>

          <div class="form-group col-sm-3">
          <label>Total Debit </label><br>
          <input type="text" name="t_debit" id="t_debit" autocomplete="off" placeholder="Total Debit" class="form-control" readonly="">
          </div>
          
          <div class="form-group col-sm-3">
          <label>Total Kredit </label><br>
          <input type="text" name="t_kredit" id="t_kredit" autocomplete="off" placeholder="Total Kredit" class="form-control" readonly="">
          </div>
          
</div>
<br>
          <div class="form-group col-sm-6">
          </div>

          <div class="form-group col-sm-3">

          <button type="submit" id="submit_jurnal_manual" class="btn btn-info"> <span class='glyphicon glyphicon-ok-sign'></span> Submit </a> </button>

          <a href="transaksi_jurnal_manual.php" style="display: none" class="btn btn-primary" id="transaksi_baru" > <span class='glyphicon glyphicon-ok-sign'></span> Transaksi Baru </a>
          
          </div>
</div> <!-- tag penutup div container -->


<script type="text/javascript" language="javascript" >
   $(document).ready(function() {
          $('#table_jurnal_tbs').DataTable().destroy();

        var dataTable = $('#table_jurnal_tbs').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_edit_tbs_jurnal.php", // json datasource
              "data": function ( d ) {
                d.no_faktur = "<?php echo $no_faktur;?>";
                // d.custom = $('#myInput').val();
                // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_tbs").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[5]);

          }

        });    
     
  });
 
 </script>

      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});  
      
      </script>

<script>
$(document).ready(function(){
        $("#kode_akun").change(function(){

          var kode_akun = $(this).val();
          
          $.getJSON('lihat_nama_akun.php',{kode_akun:$(this).val()}, function(json){
          
          if (json == null)
          {
          
          $('#nama_akun').val('');
          
          }
          
          else 
          {
          
          $('#nama_akun').val(json.nama_daftar_akun);
          }
                                              
        });

        });
    });     
</script>



<script type="text/javascript">


   $("#submit_produk").click(function(){

    var no_faktur = $("#no_faktur").val();
    var keterangan = $("#keterangan").val();
    var kode_akun = $("#kode_akun").val();
    var nama_akun = $("#nama_akun").val();
    var jenis = $("#jenis").val();
    var debit = $("#debit").val();
    var kredit = $("#kredit").val();
  
    var no_ref = $("#no_ref").val();
    var tanggal = $("#tanggal").val();

$("#nama_akun").val('');

if (nama_akun == "") {

alert('Nama Akun Masih Kosong');

}

else if(debit == "" & kredit == ""){

alert('Kolom Debit Atau Kredit Masih Kosong');

}
else{

  $.post("proses_edit_tbs_jurnal_manual.php", {no_faktur:no_faktur, keterangan:keterangan,kode_akun:kode_akun,jenis:jenis,nama_akun:nama_akun,debit:debit,kredit:kredit}, function(info) {


          $('#table_jurnal_tbs').DataTable().destroy();

        var dataTable = $('#table_jurnal_tbs').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_edit_tbs_jurnal.php", // json datasource
              "data": function ( d ) {
                d.no_faktur = "<?php echo $no_faktur;?>";
                // d.custom = $('#myInput').val();
                // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_tbs").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[5]);

          }

        });    
 

       $("#kode_akun").val('');
      $("#kode_akun").trigger('chosen:updated');
     $("#kode_akun").trigger('chosen:open');
     $("#nama_akun").val('');

       $("#debit").val('');
       $("#kredit").val('');



   });
}


  $.post("cek_edit_total_debit.php",
        {
        no_faktur: no_faktur
        },
        function(data){

        $("#t_debit").val(data);
        });



        $.post("cek_edit_total_kredit.php",
        {
        no_faktur: no_faktur
        },
        function(data){

        $("#t_kredit").val(data);
        });
        


      $("form").submit(function(){
      return false;
      });


  });

</script>


<script type="text/javascript">

        
        $(document).ready(function(){
        $(".container").hover(function(){
        
        var no_faktur = $("#no_faktur").val();
        
        $.post("cek_edit_total_debit.php",
        {
        no_faktur: no_faktur
        },
        function(data){

        $("#t_debit").val(data);
        });



        $.post("cek_edit_total_kredit.php",
        {
        no_faktur: no_faktur
        },
        function(data){

        $("#t_kredit").val(data);
        });
        
        
        });
        
        });
</script>



<script type="text/javascript">
    $(document).on('click', '#submit_jurnal_manual', function (e){

    var no_faktur = $("#no_faktur").val();
    var keterangan = $("#keterangan").val();
    var kode_akun = $("#kode_akun").val();
    var nama_akun = $("#nama_akun").val();
    var jenis = $("#jenis").val();
    var debit = $("#debit").val();
    var kredit = $("#kredit").val();
    var no_ref = $("#no_ref").val();
    var tanggal = $("#tanggal").val();
    var t_debit = $("#t_debit").val();
    var t_kredit = $("#t_kredit").val();

if(t_debit != t_kredit){


alert('Kolom Total Debit dan Total Kredit Tidak Sama');

}
else{

  $("#submit_jurnal_manual").hide();
  $("#transaksi_baru").show();

  $.post("proses_selesai_edit_jurnal_manual.php", {no_faktur:no_faktur,keterangan:keterangan,kode_akun:kode_akun,jenis:jenis,nama_akun:nama_akun,debit:debit,kredit:kredit,no_ref:no_ref,t_debit:t_debit,t_kredit:t_kredit,tanggal:tanggal}, function(info) {


          $('#table_jurnal_tbs').DataTable().destroy();

        var dataTable = $('#table_jurnal_tbs').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_edit_tbs_jurnal.php", // json datasource
              "data": function ( d ) {
                d.no_faktur = "<?php echo $no_faktur;?>";
                // d.custom = $('#myInput').val();
                // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_tbs").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[5]);

          }

        });    

      $("#kode_akun").val('');
      $("#kode_akun").trigger('chosen:updated');
      $("#kode_akun").trigger('chosen:open');
      $("#nama_akun").val('');

      $("#debit").val('');
       $("#kredit").val('');
       $("#t_debit").val('');
       $("#t_kredit").val('');

   });
}


      $("form").submit(function(){
    return false;
});
  

  });


</script>


<script type="text/javascript">   
//fungsi hapus data 
    $(document).on('click', '.btn-hapus-tbs', function (e){
    
    var nama_akun_jurnal = $(this).attr("data-nama");
    var kode_akun_jurnal = $(this).attr("data-kode-akun");
    var id = $(this).attr("data-id");
    
    
    $.post("hapus_jurnal_manual.php",{id:id,kode_akun_jurnal:kode_akun_jurnal},function(data){
    if (data == 'sukses') {
    
    
    $(".tr-id-"+id+"").remove();
       $("#kode_akun").val('');
      $("#kode_akun").trigger('chosen:updated');
     $("#kode_akun").trigger('chosen:open');
     $("#nama_akun").val('');

    }
    });
 

          $('#table_jurnal_tbs').DataTable().destroy();

        var dataTable = $('#table_jurnal_tbs').DataTable( {
          "processing": true,
          "serverSide": true,
          "ajax":{
            url :"datatable_edit_tbs_jurnal.php", // json datasource
              "data": function ( d ) {
                d.no_faktur = "<?php echo $no_faktur;?>";
                // d.custom = $('#myInput').val();
                // etc
            },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_jurnal_tbs").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data Tidak Ditemukan.. !!</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
              
            }
          },

          "fnCreatedRow": function( nRow, aData, iDataIndex ) {

              $(nRow).attr('class','tr-id-', aData[5]);

          }

        });    


    });
                  $('form').submit(function(){
                  
                  return false;
                  });
</script>

      <script>
      

      $(document).ready(function(){
      $("#debit").keyup(function(){
      var debit = $("#debit").val();
      var kredit = $("#kredit").val();
             

             if (debit != "" || debit != 0){
             $("#kredit").attr("readonly", true);
             $("#kredit").val('0');
             }
             else{
              $("#kredit").attr("readonly", false);
              $("#kredit").val('');
             }


      });
      });

      $(document).ready(function(){
      $("#kredit").keyup(function(){
      var debit = $("#debit").val();
      var kredit = $("#kredit").val();
             

             if (kredit != "" || kredit != 0){
             $("#debit").attr("readonly", true);
             $("#debit").val('0');
             }
             else{
              $("#debit").attr("readonly", false);
              $("#debit").val('');
             }

      });
      });


      $(document).ready(function(){
      $("#kode_akun").change(function(){


          var no_faktur = $("#no_faktur").val();
               
        $.post('cek_edit_tbs_jurnal_manual.php',{kode_akun:$(this).val(), no_faktur:no_faktur}, function(data){
                
          if(data == 1){

                alert ("Akun Sudah Ada, Silakan pilih Akun lain.");
                $("#kode_akun").val('');
                $("#kode_akun").trigger('chosen:updated');
                $("#nama_akun").val('');
                $("#debit").attr("readonly", true);
                $("#kredit").attr("readonly", true);
            }
                
          else 
            {
              
              $("#debit").attr("readonly", false);
              $("#kredit").attr("readonly", false);
              
              $("#debit").val('');
              $("#kredit").val('');


            }
              
        });

      });
 });
</script>


                             <script type="text/javascript">
                                 
                                 $(document).on('click', '.edit-debit', function (e){

                                    var id = $(this).attr("data-id");

                                    $("#text-debit-"+id+"").hide();

                                    $("#input-debit-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input-debit', function (e){

                                    var id = $(this).attr("data-id");

                                    var input_debit = $(this).val();


                                    $.post("update_jurnal_manual.php",{id:id, input_debit:input_debit,jenis_edit:"debit"},function(data){

                                    $("#text-debit-"+id+"").show();
                                    $("#text-debit-"+id+"").text(input_debit);

                                    $("#input-debit-"+id+"").attr("type", "hidden");           

                                    });

                                          $(document).ready(function(){
                                            var no_faktur = $("#no_faktur").val();
                                            
                                            $.post("cek_edit_total_debit.php",
                                            {
                                            no_faktur: no_faktur
                                            },
                                            function(data){
                                            
                                            $("#t_debit").val(data);
                                            });
                                            
                                            
                                            
                                            $.post("cek_edit_total_kredit.php",
                                            {
                                            no_faktur: no_faktur
                                            },
                                            function(data){
                                            
                                            $("#t_kredit").val(data);
                                            });
                                           });

                                 });

                             </script>


                             <script type="text/javascript">
                                 
                                 $(document).on('click', '.edit-kredit', function (e){

                                    var id = $(this).attr("data-id");

                                    $("#text-kredit-"+id+"").hide();

                                    $("#input-kredit-"+id+"").attr("type", "text");

                                 });

                                 $(document).on('blur', '.input-kredit', function (e){

                                    var id = $(this).attr("data-id");

                                    var input_kredit = $(this).val();


                                    $.post("update_jurnal_manual.php",{id:id, input_kredit:input_kredit,jenis_edit:"kredit"},function(data){

                                    $("#text-kredit-"+id+"").show();
                                    $("#text-kredit-"+id+"").text(input_kredit);

                                    $("#input-kredit-"+id+"").attr("type", "hidden");           

                                    });
                                          $(document).ready(function(){
                                            var no_faktur = $("#no_faktur").val();
                                            
                                            $.post("cek_edit_total_debit.php",
                                            {
                                            no_faktur: no_faktur
                                            },
                                            function(data){
                                            
                                            $("#t_debit").val(data);
                                            });
                                            
                                            
                                            
                                            $.post("cek_edit_total_kredit.php",
                                            {
                                            no_faktur: no_faktur
                                            },
                                            function(data){
                                            
                                            $("#t_kredit").val(data);
                                            });
                                           });
                                      });

                             </script>

<?php 
include 'footer.php';
 ?>