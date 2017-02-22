<?php include 'session_login.php';

 include 'header.php';
 include 'navbar.php';
 include 'db.php';

 
 $no_faktur = $_GET['no_faktur'];
 
 $query = $db->query("SELECT * FROM detail_item_keluar WHERE no_faktur = '$no_faktur'");
 
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>



<form action="update_detail_item_keluar.php" method="post">
<div class="container">

<div class="form-group">
					
					<h3>Edit Jumlah Item Keluar </h3><br><br>

					<div class="form-group">
					<label> Jumlah Baru </label><br>
					<input type="text" id="jumlah_baru" name="jumlah_baru" class="form-control" required=""></input>
					</div>

					<input type="hidden" name="jumlah" value="<?php echo $data['jumlah']; ?>" class="form-control" required="">
					
					<input type="hidden" name="no_faktur" value="<?php echo $data['no_faktur']; ?>" class="form-control" required="">

					<input type="hidden" name="kode_barang" value="<?php echo $data['kode_barang']; ?>" class="form-control" required="">
					
					<button type="submit" class="btn btn-info">Edit</button>
</div>
</form>
