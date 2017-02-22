<?php include 'session_login.php';


 include 'db.php';
 include 'sanitasi.php';
 include 'header.php';
 include 'navbar.php';
 

  $query = $db->query("SELECT * FROM fee_faktur");

 ?>
 <div class="container">
 	<div class="row">



<h1> FORM KOMISI FAKTUR / PETUGAS </h1>



<br><br>
        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-danger btn-md" id="cari_petugas" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-search"> </span> Cari Petugas</button>
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

<form action="proses_fee_produk.php" method="post">
          <div class="form-group">
          <label> Nama Petugas </label><br>
          <input type="text" name="nama_petugas" id="nama_petugas" placeholder="Nama Petugas" class="form-control" readonly="">
          </div>



<span id="prosentase">
					<div class="form-group">
					<label> Jumlah Prosentase ( % ) </label><br>
					<input type="text" name="jumlah_prosentase" placeholder="Jumlah Prosentase" id="jumlah_prosentase" class="form-control" autocomplete="off">
					</div>
</span>
<span id="nominal">
					<div class="form-group">
					<label> Jumlah Nominal ( Rp )</label><br>
					<input type="text" name="jumlah_uang" id="jumlah_nominal" placeholder="Jumlah Nominal" class="form-control" autocomplete="off">
					</div>
</span>
</form>
					<button type="submit" id="tambah_fee" class="btn btn-info"><span class="glyphicon glyphicon-plus"> </span> Tambah</button>
          <br>
          <br>



<span id="alert">
  

</span>

</div><!-- end row -->
<br>
<br>
<label> User : <?php echo $_SESSION['user_name']; ?> </label> 



<span id="demo"> </span>
</div><!-- end container -->

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


   <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#tambah_fee").click(function(){

       var nama_petugas = $("#nama_petugas").val();
       var jumlah_prosentase = $("#jumlah_prosentase").val();
       var jumlah_nominal = $("#jumlah_nominal").val();
       
       

 if (jumlah_prosentase > 100)
 {

  alert("Jumlah Prosentase Melebihi 100% ");

 }

 else if (nama_petugas == "") {

  alert ("Silahkan Isi Nama Petugas")
 }

 else

 {

 	$.post("proses_tambah_fee_faktur_petugas.php",{nama_petugas:nama_petugas,jumlah_prosentase:jumlah_prosentase,jumlah_uang:jumlah_nominal},function(info){

$("#alert").html(info);

    $("#alert_berhasil").show('fast');
    $("#alert_gagal").show('fast');
     $("#jumlah_prosentase").val('');
     $("#jumlah_nominal").val('');
     $("#nama_petugas").val('');

    
       
   });



 }


 $("form").submit(function(){
    return false;
});

    

  });
        
  </script>

  <script type="text/javascript">
  
      $("#jumlah_prosentase").keyup(function(){
      var jumlah_prosentase = $("#jumlah_prosentase").val();
      var jumlah_nominal = $("#jumlah_nominal").val();
      
      if (jumlah_prosentase > 100)
      {

          alert("Jumlah Prosentase Tidak Boleh Lebih dari 100%");
          $("#jumlah_prosentase").val('');
      }

      else if (jumlah_prosentase == "") 
      {
        $("#nominal").show();
      }

      else
      {
            $("#nominal").hide();
      }


    
      });


              $("#jumlah_nominal").keyup(function(){
              var jumlah_nominal = $("#jumlah_nominal").val();
              var jumlah_prosentase = $("#jumlah_prosentase").val();
              
              if (jumlah_nominal == "") 
              {
              $("#prosentase").show();
              }
              
              else
              {
              $("#prosentase").hide();
              }
              
              
              
              });


     

  </script>

  <?php include 'footer.php'; ?>
