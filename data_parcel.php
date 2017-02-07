<?php include 'session_login.php';

//memasukkan file session login, header, navbar, db.php
include 'header.php';
include 'navbar.php';
include 'sanitasi.php';
include 'db.php';

?>

<!-- js untuk tombol shortcut -->
 <script src="shortcut.js"></script>
<!-- js untuk tombol shortcut -->

<style>
	tr:nth-child(even){background-color: #f2f2f2}
</style>


 <div class="container">

 <h3><b> DATA PARCEL</b></h3><hr>

<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-shopping-basket" id="tambah_parcel"> </i>
PARCEL (F1) </button>
<br><br>

<div class="collapse" id="collapseExample">

	<form class="form" role="form" id="formparcel">
		<div class="row">
		  <div class="col-sm-2">
		    <input type="text" style="height:15px" class="form-control" name="kode_parcel" autocomplete="off" id="kode_parcel" placeholder="KODE PARCEL">
		  </div>

		  <div class="col-sm-3">
		    <input style="height:15px;" type="text" class="form-control" name="nama_parcel" autocomplete="off" id="nama_parcel" placeholder="NAMA PARCEL">
		  </div>

		  <div class="col-sm-2">
		  	  <button type="submit" id="submit_parcel" class="btn btn-info" style="font-size:15px"> <i class="fa fa-plus"> </i> Tambah (F2)</button>
		  </div>
		</div>
	</form> <!-- END FORM -->

</div> <!-- END collapseExample -->


<div class="table-responsive"><!--membuat agar ada garis pada tabel disetiap kolom-->
<span id="tabel-parcel">
	<table id="tabel_parcel" class="table table-bordered table-sm">
		<thead>

			<th style='background-color: #4CAF50; color: white'> Kode Parcel </th>
			<th style='background-color: #4CAF50; color: white'> Nama Parcel</th>
			<th style='background-color: #4CAF50; color: white'> Edit </th>
			<th style='background-color: #4CAF50; color: white'> Hapus </th>

		</thead>
	</table>
</span>
</div>

</div> <!-- END CONTAINER -->


<!-- SHORTCUT -->
<script> 
    shortcut.add("f1", function() {

        $("#tambah_parcel").click();

    });

    
    shortcut.add("f2", function() {

        $("#submit_parcel").click();

    });

</script>
<!-- SHORTCUT -->

<?php include 'footer.php'; ?>