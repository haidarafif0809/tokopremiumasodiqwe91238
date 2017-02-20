<?php include 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';


 ?>
<div class="container">
<h1><b>Perubahan Harga Masal</b></h1>
<br>
<form role="form" method="post" id="data_form">
<div class="row"><!--row first-->

	<div class="col-sm-3">
		<div class="form-group">
		<label>Kategori</label>
        <select type="text" name="kategori" id="kategori" class="form-control" autocomplete="off" required="">
        <option value="">Silahkan Pilih</option>
          <?php 
          $query = $db->query("SELECT id,nama_kategori  FROM kategori");
          while($data = mysqli_fetch_array($query))
          {
          echo "<option value='".$data['nama_kategori']."'>".$data['nama_kategori'] ."</option>";
          }      
          ?>
         </select>
        </div>
	</div>

	<div class="col-sm-3">
		<label>Perubahan Harga</label>
        <select type="text" name="change_price" id="change_price" class="form-control" autocomplete="off" required="">
	        <option value="">Silahkan Pilih</option>
	        <option value="Level 1">Level 1</option>
	        <option value="Level 2">Level 2</option>
	        <option value="Level 3">Level 3</option>
	        <option value="Level 4">Level 4</option>
	        <option value="Level 5">Level 5</option>
	        <option value="Level 6">Level 6</option>
	        <option value="Level 7">Level 7</option>
         </select>
	</div>

	<div class="col-sm-3">
		<div class="form-group">
		<label>Acuan Harga</label>
	    <select type="text" name="acuan_price" id="acuan_price" class="form-control" autocomplete="off" required="">
	      	<option value="">Silahkan Pilih</option>
	        <option value="HPP">HPP</option>
	        <option value="Level 1">Level 1</option>
	        <option value="Level 2">Level 2</option>
	        <option value="Level 3">Level 3</option>
	        <option value="Level 4">Level 4</option>
	        <option value="Level 5">Level 5</option>
	        <option value="Level 6">Level 6</option>
	        <option value="Level 7">Level 7</option>
         </select>
        </div>
	</div>

<br>
<br>
<br>
	<div class="col-sm-3">
		<button type="submit" id="submit_ok" class="btn btn-info" >Data Ok</button>
	</div>

</div><!--End row first-->	


<div class="row"><!--row two-->

	<div class="col-sm-3">
		<div class="form-group">
		<label>Pola Perubahan</label><br>
	    <select type="text" name="sistem_change" id="sistem_change" class="form-control" autocomplete="off" required="">
	      	<option value="">Silahkan Pilih</option>
	        <option value="Naik">Naik</option>
	        <option value="Turun">Turun</option>
         </select>
        </div>
	</div>

	<div class="col-sm-2">
	<label>Nilai</label><br>
	    <input type="text" name="jumlah_nilai" id="jumlah_nilai" class="form-control" autocomplete="off">
	</div>

	<div class="col-sm-2">
	 <div class="form-group"><br><br>
	 <select type="text" name="nilai" id="nilai" class="form-control" autocomplete="off" required="">
	      	<option value="">Silahkan Pilih</option>
	        <option value="Persentase">Persentase</option>
	        <option value="Nominal">Nominal</option>
         </select>

    
        </div>
	</div>

	<div class="col-sm-2">
	<label>Pembulatan</label>
	  <input type="text" name="pembulatan" id="pembulatan" value="25" class="form-control" autocomplete="off" readonly="">
	</div>
</div><!--End row two-->	
</form>


</div><!-- div close container-->

<script>
$(document).on('click', '#submit_ok', function (e) {

   	var kategori = $("#kategori").val();
   	var change_price = $("#change_price").val();
   	var acuan_price = $("#acuan_price").val();
   	var sistem_change = $("#sistem_change").val();
   	var jumlah_nilai = $("#jumlah_nilai").val();
   	var nilai = $("#nilai").val();
   	var pembulatan = $("#pembulatan").val();


if (kategori == "")
{
	alert('Pilih Dahulu Kategori');
	$("#kategori").focus();
}
else if (change_price == "")
{	
	alert('Pilih Harga Yang akan di ubah');
	$("#change_price").focus();
}
else if (acuan_price == "")
{	
	alert('Pilih Harga Yang Menjadi Acuan');
	$("#acuan_price").focus();
}
else if (sistem_change == "")
{	
	alert('Pilih Pola Perubahan Harga');
	$("#sistem_change").focus();
}
else if (jumlah_nilai == "")
{	
	alert('Isi Jumlah Nilai');
	$("#jumlah_nilai").focus();
}
else if (nilai == "")
{	
	alert('Pilih Dahulu Nilai Persentase / Nominal');
	$("#nilai").focus();
}
else
{

	$.post("proses_harga_masal.php", {kategori:kategori, change_price:change_price,
		acuan_price:acuan_price, sistem_change:sistem_change, jumlah_nilai:jumlah_nilai,
		nilai:nilai, pembulatan:pembulatan}, function(info) {

     $("#data_form").html(info);
     $("#data_form").hide();
     	var nomor = info;
     	window.location.href="proses_tbs_harga_masal.php?nomor="+nomor+"";

       // window.location.href="data_perubahan_masal.php?nomor="+nomor+"";

   });
}


      $("#data_form").submit(function(){
    return false;
});
  

  });

</script>



<!-- cek stok satuan konversi change-->
<script type="text/javascript">
  $(document).ready(function(){
$(document).on('change', '#kategori', function (e) {
 	
      var kategori = $("#kategori").val();

      $.post("cek_kategori_barang.php", {kategori:kategori},function(data){

          if (data != 1) {
            alert("Barang dengan kategori tersebut tidak ada !!");
            $("#kategori").val('');
          $("#kategori").val(prev);

          }

      });
    });
  });
</script>
<!-- end cek stok satuan konversi change-->






 <?php 
include 'footer.php';
 ?>