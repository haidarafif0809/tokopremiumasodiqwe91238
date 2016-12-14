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
<h3>KOMISI / PETUGAS</h3><hr>


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
      <th> Otoritas </th>
      <th> Status </th>

      
    </thead>
    
    <tbody>
    <?php

      $perintah0 = $db->query("SELECT * FROM user");
      while ($data1 = mysqli_fetch_array($perintah0))
      {
      echo "<tr  class='pilih' data-petugas='". $data1['nama'] ."'>
      <td>". $data1['username'] ."</td>
      <td>". $data1['nama'] ."</td>
      <td>". $data1['alamat'] ."</td>
      <td>". $data1['jabatan'] ."</td>
      <td>". $data1['otoritas'] ."</td>
      <td>". $data1['status'] ."</td>

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

                  <input type="text" name="nama_petugas" id="nama_petugas" class="form-control" placeholder="Nama Petugas" required="">
                  </div>                  

                  <div class="form-group"> 

                  <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control" placeholder="Dari Tanggal" required="">
                  </div>

                  <div class="form-group"> 

                  <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control" placeholder="Sampai Tanggal" required="">
                  </div>

                  <button type="submit" name="submit" id="submit" class="btn btn-primary" > <i class="fa fa-send"></i> Submit </button>

</form>


<br>

<span id="result">

<h3><center><b>Komisi Faktur / Petugas</b></center></h3><br><br>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
            <thead>
                  <th style="background-color: #4CAF50; color: white;"> Nama Petugas </th>
                  <th style="background-color: #4CAF50; color: white;"> Nomor Faktur </th>
                  <th style="background-color: #4CAF50; color: white;"> Kode Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Nama Produk </th>
                  <th style="background-color: #4CAF50; color: white;"> Jumlah Komisi </th>
                  <th style="background-color: #4CAF50; color: white;"> Tanggal </th>
                  <th style="background-color: #4CAF50; color: white;"> Jam </th>


                  
            </thead>
            
            <tbody>

     
            </tbody>

      </table>
</div>
<br><br>

<h3><center><b>Komisi Produk / Petugas</b></center></h3><br><br>
<div class="table-responsive">
<table id="tableuser" class="table table-bordered">
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
</div>

      
</span>
</div>

<script>
// untuk memunculkan data tabel 
$(document).ready(function(){
    $('.table').DataTable();


});
  
</script>

<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("nama_petugas").value = $(this).attr('data-petugas');

  $('#myModal').modal('hide');
  });
   


   
  </script> <!--tag penutup perintah java script-->

<script type="text/javascript">
$("#submit").click(function(){

      var nama_petugas = $("#nama_petugas").val();
      var dari_tanggal = $("#dari_tanggal").val();
      var sampai_tanggal = $("#sampai_tanggal").val();


$.post("proses_laporan_jumlah_total_fee.php", {nama_petugas:nama_petugas,dari_tanggal:dari_tanggal,sampai_tanggal:sampai_tanggal},function(info){

 $("#result").html(info);

});


});      
$("form").submit(function(){

return false;

});

</script>




<?php 
include 'footer.php';
 ?>