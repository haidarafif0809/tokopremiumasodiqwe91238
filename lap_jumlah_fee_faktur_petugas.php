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



<div class="container">
<h3>KOMISI FAKTUR / PETUGAS</h3><hr>


<button type="button" class="btn btn-danger btn-md" id="cari_petugas" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"> </i> Cari Petugas</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data User</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->
<span class="modal_baru">
 <div class="table-responsive">       
<table id="tableuser" class="table table-bordered">
    <thead>
      <th> Username </th></th>
      <th> Nama Lengkap </th>
      <th> Alamat </th>
      <th> Jabatan </th>

      
    </thead>
    
    <tbody>
    <?php

      $perintah0 = $db->query("SELECT u.id,u.username,u.nama,u.alamat,j.nama AS jabatan FROM user u LEFT JOIN jabatan j ON u.jabatan = j.id ");
      while ($data1 = mysqli_fetch_array($perintah0))
      {
      echo "<tr  class='pilih' data-petugas='". $data1['id'] ."' data-petugas1='". $data1['nama'] ."'>
      <td>". $data1['username'] ."</td>
      <td>". $data1['nama'] ."</td>
      <td>". $data1['alamat'] ."</td>
      <td>". $data1['jabatan'] ."</td>

      </tr>";
      }

      //Untuk Memutuskan Koneksi Ke Database
      mysqli_close($db);   
    ?>
    </tbody>

  </table>
</div>
</span>
          
</div> <!-- tag penutup modal body -->
        
        <!-- tag pembuka modal footer -->
        <div class="modal-footer">
       
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> <!--tag penutup moal footer -->
        </div>
        
        </div>
        </div>

<br>      
<form class="form-inline" role="form">
              
                  <div class="form-group"> 

                  <input type="text" name="nama_petugas1" id="nama_petugas1" class="form-control" placeholder="Nama Petugas" required="">
                  </div> 
                  <input type="hidden" name="nama_petugas" id="nama_petugas" class="form-control" placeholder="Nama Petugas" required="">                 

                  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-send"></i> Submit </button>

</form>


<br>
    <div class="card card-block" id="tampil" style="display:none">
      <div class="table-responsive">
        <span id="result">
        <table id="table-lap" class="table table-bordered">
                    <thead>
                          <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                          <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                          <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                          <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                          <th style="background-color: #4CAF50; color: white;"> Jam </th>

                          
                    </thead>
                    
                    <tbody>

                    </tbody>

              </table>

              
        </span>
      </div>

            <a href='' id='cetak' class='btn btn-success' target='blank'><i class='fa fa-print'> </i> Cetak Komisi / Faktur </a>
            <h3 id='judul' style="color: red"> </h3>


    </div>
</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('#tableuser').DataTable();


});
  
</script>

<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("nama_petugas").value = $(this).attr('data-petugas');
  document.getElementById("nama_petugas1").value = $(this).attr('data-petugas1');

  $('#myModal').modal('hide');
  });
   


   
  </script> <!--tag penutup perintah java script-->

<script type="text/javascript">
$(document).on('click','#submit',function(){

      var nama_petugas = $("#nama_petugas").val();
      var petugas = $("#nama_petugas1").val();
      var dari_tanggal = $("#dari_tanggal").val();
      var sampai_tanggal = $("#sampai_tanggal").val();

      if (nama_petugas == '') {

         alert("Nama petugas belum anda isi!");

      }else if (dari_tanggal == '') {

        alert("Dari tanggal belum anda isi!!");

      }else if (sampai_tanggal == '') {

        alert("Sampai tanggal belum anda isi!!");

      }else{

                  $('#table-lap').DataTable().destroy();

                var dataTable = $('#table-lap').DataTable( {
                "processing": true,
                "serverSide": true,
                "info":     true,
                "language": {
              "emptyTable":     "My Custom Message On Empty Table"
                },
                "ajax":{
                  url :"proses_lap_jumlah_fee_faktur.php", // json datasource
                   "data": function ( d ) {
                      d.nama_petugas = $("#nama_petugas").val();
                      d.dari_tanggal = $("#dari_tanggal").val();
                      d.sampai_tanggal = $("#sampai_tanggal").val();
                      // d.custom = $('#myInput').val();
                      // etc
                    },
                      type: "post",  // method  , by default get
                  error: function(){  // error handling
                    $(".tbody").html("");
                    $("#table-lap").append('<tbody class="tbody"><tr><th colspan="3"></th></tr></tbody>');
                    $("#table-lap_processing").css("display","none");
                    
                  }
                }
          


              });

          $.post("cek_total_fee_faktur.php",{nama_petugas:nama_petugas,dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(data){

                      $("#tampil").show();
                      $("#cetak").attr('href','cetak_lap_fee_faktur.php?petugas='+petugas+'&nama_petugas='+nama_petugas+'&dari_tanggal='+dari_tanggal+'&sampai_tanggal='+sampai_tanggal+'&total_fee='+data);
                      $("#judul").text('Total Komisi / Faktur Dari '+dari_tanggal+' s/d '+sampai_tanggal+' Sebesar '+tandaPemisahTitik(data));
          });
          

      }


  });

     
$("form").submit(function(){

return false;

});

</script>




<?php 
include 'footer.php';
 ?>