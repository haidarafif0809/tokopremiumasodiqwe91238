<?php include 'session_login.php';


 include 'db.php';
 include 'sanitasi.php';
 include 'header.php';
 include 'navbar.php';
 

  $query = $db->query("SELECT * FROM fee_faktur");

 ?>
 <div class="container">
 	<div class="row">



<h1> FORM KOMISI FAKTUR / JABATAN </h1>
<br><br>

        
<form action="proses_fee_faktur_jabatan.php" method="post">

<span id="prosentase">
					<div class="form-group">
					<label> Jumlah Prosentase </label><br>
					<input type="text" name="jumlah_prosentase" placeholder="Jumlah Prosentase" id="jumlah_prosentase" class="form-control" autocomplete="off">
					</div>
</span>

<span id="nominal">
					<div class="form-group">
					<label> Jumlah Nominal </label><br>
					<input type="text" name="jumlah_uang" id="jumlah_nominal" placeholder="Jumlah Nominal" class="form-control" autocomplete="off">
					</div>
</span>

					<div class="form-group">
					<label> Jabatan </label><br>
					<select type="text" name="jabatan" id="jabatan" class="form-control">
					<option value="">--SILAHKAN PILIH--</option>



					 <?php 

    
    $query = $db->query("SELECT * FROM jabatan ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option>".$data['nama'] ."</option>";
    }
    
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);     
    ?>
   					</select>
					</div>

					<button type="submit" id="tambah_fee" class="btn btn-info"> <span class='glyphicon glyphicon-plus'> </span> Tambah</button>


</form>

<span id="alert">
  

</span>

</div><!-- end row -->
<br>
<br>
<label> User : <?php echo $_SESSION['user_name']; ?> </label> 



<span id="demo"> </span>
</div><!-- end container -->

<script type="text/javascript">
  
  $(document).ready(function () {
  $('.table').dataTable();
  });

</script>
<!-- untuk memasukan perintah javascript -->
<script type="text/javascript">

// jika dipilih, nim akan masuk ke input dan modal di tutup
  $(document).on('click', '.pilih', function (e) {
  document.getElementById("kode_produk").value = $(this).attr('data-kode');
  document.getElementById("nama_produk").value = $(this).attr('nama-barang');

  
  $('#myModal').modal('hide');
  });
   



   
  </script> <!--tag penutup perintah java script-->

   <script>
   //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
  $("#tambah_fee").click(function(){

       var jumlah_prosentase = $("#jumlah_prosentase").val();
       var jumlah_nominal = $("#jumlah_nominal").val();
       var jabatan = $("#jabatan").val();
       

 if (jabatan == "") {

  alert ("Silahkan Isi Jabatan")
 }


 else

 {

 	$.post("proses_fee_faktur_jabatan.php",{jumlah_prosentase:jumlah_prosentase,jumlah_uang:jumlah_nominal,jabatan:jabatan},function(info){

$("#alert").html(info);

    $("#alert_berhasil").show();
    $("#alert_gagal").show();
     $("#jumlah_prosentase").val('');
     $("#jumlah_nominal").val('');
     $("#jabatan").val('');

    
       
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
      var jumlah_nominal = $("#jumlah_norminal").val();
      
      if (jumlah_prosentase > 100)
      {

          alert("Jumlah Prosentase Melebihi 100%");
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

  