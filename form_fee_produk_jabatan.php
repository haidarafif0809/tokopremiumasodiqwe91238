<?php include 'session_login.php';


 
 include 'db.php';
 include 'sanitasi.php';
 include 'persediaan.function.php';
 include 'header.php';
 include 'navbar.php';
 



 ?>
 <div class="container">
 	<div class="row">



<h1>FORM KOMISI PRODUK / JABATAN </h1>
<br><br>
        <!-- membuat tombol agar menampilkan modal -->
        <button type="button" class="btn btn-warning btn-lg" id="cari_produk" data-toggle="modal" data-target="#myModal"> <span class='glyphicon glyphicon-search'> </span> Cari Produk</button>
        <br><br>
        <!-- Tampilan Modal -->
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
        
        <!-- Isi Modal-->
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Data Barang</h4>
        </div>
        <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
        
        <!--perintah agar modal update-->
        <span class="modal_baru">
         <div class="table-responsive">                             <!-- membuat agar ada garis pada tabel, disetiap kolom-->
 <table id="tableuser" class="table table-bordered">

        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
            <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual </th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php


        
        $perintah = $db->query("SELECT b.kode_barang,b.nama_barang,b.satuan,b.harga_beli, b.harga_jual,s.nama FROM barang b LEFT JOIN satuan s ON b.satuan = s.id ");
        
        //menyimpan data sementara yang ada pada $perintah
        while ($data1 = mysqli_fetch_array($perintah))
        {
        
        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'
        satuan='". $data1['satuan'] ."' harga='". $data1['harga_beli'] ."' jumlah-barang='". cekStokHpp($data1['kode_barang']) ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". rp($data1['harga_beli']) ."</td>
            <td>". rp($data1['harga_jual']) ."</td>
            <td>". cekStokHpp($data1['kode_barang']) ."</td>
            <td>". $data1['nama'] ."</td>
            </tr>";
      
         }

?>
    
        </tbody> <!--tag penutup tbody-->
        
        </table> <!-- tag penutup table-->
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
					<div class="form-group">
					<label> Nama Produk </label><br>
					<input type="text" name="nama_produk" id="nama_produk" placeholder="Nama Produk" class="form-control" readonly="">
					</div>

					<div class="form-group">
					<label> Kode Produk </label><br>
					<input type="text" name="kode_produk" id="kode_produk" placeholder="Kode Produk " class="form-control" readonly="" >
					</div>

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

    
    $query = $db->query("SELECT id, nama FROM jabatan ");
    while($data = mysqli_fetch_array($query))
    {
    
    echo "<option value='".$data['id']."' >".$data['nama'] ."</option>";
    }
    
//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db);     
    ?>
   					</select>
					</div>

					<button type="submit" id="tambah_fee" class="btn btn-info"> <span class='glyphicon glyphicon-plus'> </span> Tambah</button>

</div>
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

       var nama_produk = $("#nama_produk").val();
       var kode_produk = $("#kode_produk").val();
       var jumlah_prosentase = $("#jumlah_prosentase").val();
       var jumlah_nominal = $("#jumlah_nominal").val();
       var jabatan = $("#jabatan").val();
       

 if (nama_produk == "") {

  alert ("Silahkan Isi Nama Produk")
 }

 else if (kode_produk == "") {

  alert ("Silahkan Isi Kode Produk")
 }

 else

 {

 	$.post("proses_tambah_fee_produk_jabatan.php",{nama_produk:nama_produk,kode_produk:kode_produk,jumlah_prosentase:jumlah_prosentase,jumlah_uang:jumlah_nominal,jabatan:jabatan},function(info){

$("#alert").html(info);

    $("#alert_berhasil").show();
    $("#alert_gagal").show();
     $("#nama_produk").val('');
     $("#kode_produk").val('');
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

          alert("Jumlah Prosentase Melebihi ??");
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

  <script type="text/javascript">
    
  $("#cari_produk").click(function(){

    $("[type='search']").focus();

  });

  </script>

  <?php include 'footer.php'; ?>


  