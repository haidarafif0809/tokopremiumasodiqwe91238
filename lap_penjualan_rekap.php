<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>

     <script>
    $(function() {
    $( "#dari_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>


    <script>
    $(function() {
    $( "#sampai_tanggal" ).datepicker({dateFormat: "yy-mm-dd"});
    });
    </script>

<style>

tr:nth-child(even){background-color: #f2f2f2}

</style>

 <div class="container">

<h3> LAPORAN PENJUALAN REKAP </h3><hr>

<form class="form-inline" role="form">  

          <div class="form-group" style="display: none"> 

             <select type="text" name="kategori" id="kategori" class="form-control chosen" required="">
              <option value="Semua Kategori"> Semua Kategori </option>
          <?php 

          $ambil_kategori = $db->query("SELECT nama_kategori FROM kategori");
              while($data_kategori = mysqli_fetch_array($ambil_kategori))
              {  
            echo "<option value='".$data_kategori['nama_kategori'] ."' >".$data_kategori['nama_kategori'] ."</option>";
               }

          ?>
                   </select> 
                  </div>

        
          <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" ><i class="fa fa-eye"> </i> Tampil </button>

</form>

 <br>
 <div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="result">
<table id="table_lap_penjualan_rekap" class="table table-bordered table-sm">
    <thead>
      <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Kode Pelanggan</th>
      <th style="background-color: #4CAF50; color: white;"> Tanggal </th> 
      <th style="background-color: #4CAF50; color: white;"> Jam </th>
      <th style="background-color: #4CAF50; color: white;"> User </th>
      <th style="background-color: #4CAF50; color: white;"> Status </th>
      <th style="background-color: #4CAF50; color: white;"> Total Kotor</th>
      <th style="background-color: #4CAF50; color: white;"> Potongan </th>
      <th style="background-color: #4CAF50; color: white;"> Tax </th>
      <th style="background-color: #4CAF50; color: white;"> Total Bersih</th>
      <th style="background-color: #4CAF50; color: white;"> Tunai </th>
      <th style="background-color: #4CAF50; color: white;"> Kembalian </th>
      <th style="background-color: #4CAF50; color: white;"> Kredit </th>
            
    </thead>
    <tbody>
      

    </tbody>

  </table>
</span>
</div> <!--/ responsive-->
<span id="cetak" style="display: none;">
  <br><a href='cetak_lap_penjualan_rekap.php' target="blank" id="cetak_lap" class='btn btn-success'><i class='fa fa-print'> </i> Cetak Penjualan </a>
</span>
</div> <!--/ container-->

    <!--script>
    
    $(document).ready(function(){
    $('#tableuser').DataTable();
    });
    </script-->

    
    <!--script type="text/javascript">
    $("#submit").click(function(){
    
    var dari_tanggal = $("#dari_tanggal").val();
    var sampai_tanggal = $("#sampai_tanggal").val();
    
    
    $.post("proses_lap_penjualan_rekap.php", {dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){
    
    $("#result").html(info);
    
    });
    
    
    });      
    $("form").submit(function(){
    
    return false;
    
    });
    
    </script-->
    <script type="text/javascript">     
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!"});      
      </script>
  
<script type="text/javascript">
    $(document).on('click','#submit',function(e){
      $('#table_lap_penjualan_rekap').DataTable().destroy();
      var dari_tanggal = $("#dari_tanggal").val();
          var sampai_tanggal = $("#sampai_tanggal").val();
          if (dari_tanggal == '') {
            alert("Silakan dari tanggal diisi terlebih dahulu.");
            $("#dari_tanggal").focus();
          }
          else if (sampai_tanggal == '') {
            alert("Silakan sampai tanggal diisi terlebih dahulu.");
            $("#sampai_tanggal").focus();
          }
            else{
      
          var dataTable = $('#table_lap_penjualan_rekap').DataTable( {
          "processing": true,
          "serverSide": true,
          "info": false,
          "ajax":{
            url :"datatable_lap_penjualan_rekap.php", // json datasource
            "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
            type: "post",  // method  , by default get
            error: function(){  // error handling
              $(".employee-grid-error").html("");
              $("#table_lap_penjualan_rekap").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
              $("#employee-grid_processing").css("display","none");
            }
        },
            
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('class','tr-id-'+aData[11]+'');
            },

        });

        $("#cetak").show();
        $("#cetak_lap").attr("href", "cetak_lap_penjualan_rekap.php?&dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal, "_blank");
        }//end else
        $("form").submit(function(){
        return false;
        });
    
    });
    
    </script>


<?php 
include 'footer.php';
 ?>