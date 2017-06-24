<?php include 'session_login.php';


//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>


 <div class="container">

<h3> LAPORAN PENJUALAN PIUTANG </h3><hr>

<form class="form-inline" role="form">
				
				  <div class="form-group"> 
                  	<input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control tanggal_cari" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 
                  	<input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control tanggal_cari" placeholder="Sampai Tanggal" value="<?php echo date("Y-m-d"); ?>" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-eye"></i> Tampil </button>

</form>

 <br>
 <div class="table-responsive" id="respon" ><!--membuat agar ada garis pada tabel disetiap kolom-->
<table id="tableuser" class="table table-bordered table-sm">
    <thead>

      <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Nama Pelanggan</th>
      <th style="background-color: #4CAF50; color: white;"> Tgl. Transaksi</th>
      <th style="background-color: #4CAF50; color: white;"> Tgl. Jatuh Tempo</th>
      <th style="background-color: #4CAF50; color: white;"> Umur Piutang </th>
      <th style="background-color: #4CAF50; color: white;"> Nilai Faktur </th>
      <th style="background-color: #4CAF50; color: white;"> Dibayar </th>
      <th style="background-color: #4CAF50; color: white;"> Piutang </th>
            
    </thead>

  </table>
</div> <!--/ responsive-->


       <a href='cetak_laporan_penjualan_piutang.php' style="display: none" class='btn btn-success'  id="cetak_non" target='blank'><i class='fa fa-print'> </i> Cetak Penjualan Piutang</a>  

       <a href='download_lap_penjualan_piutang.php' style="display: none" type='submit' target="blank" id="btn-download-non" class='btn btn-purple'><i class="fa fa-download"> </i> Download Excel</a>


</div> <!--/ container-->


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



<script type="text/javascript">
    $("#submit").click(function(){
    
    var dari_tanggal = $("#dari_tanggal").val();
    var sampai_tanggal = $("#sampai_tanggal").val();
        
      $("#respon").show();
      $('#tableuser').DataTable().destroy();

      var dataTable = $('#tableuser').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":   "My Custom Message On Empty Table"
          },
                "ajax":{
                  url :"datatable_laporan_penjualan_piutang.php", // json datasource
                   "data": function ( d ) {
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                  },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#tableuser").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#tableuser_processing").css("display","none");
                    
                  }
                }
          
              });
    
     $("#cetak_non").show();
     $("#btn-download-non").show();
     $("#cetak_non").attr("href", "cetak_laporan_penjualan_piutang.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
     $("#btn-download-non").attr("href", "download_lap_penjualan_piutang.php?dari_tanggal="+dari_tanggal+"&sampai_tanggal="+sampai_tanggal+"");
     $("#cetak_true").hide();
     $("#btn-download-true").hide();


    
    });      
    $("form").submit(function(){
    
    return false;
    
    });
    
    </script>


<?php 
include 'footer.php';
 ?>