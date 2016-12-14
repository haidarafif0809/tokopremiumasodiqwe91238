<?php include 'session_login.php';

 include 'db.php';
 include 'header.php';
 include 'navbar.php';


 $id = $_GET['id'];
 
 $query = $db->query("SELECT * FROM kas_mutasi WHERE id = '$id'");
 
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>




<form action="update_kas_mutasi.php" method="post">
<div class="container">

<div class="form-group">
					
					<h3>Edit Jumlah Kas Mutasi </h3><br><br>

					<div class="form-group">
					<label> Jumlah Baru </label><br>
					<input type="text" name="jumlah_baru" class="form-control" required=""></input>
					</div>

					<input type="hidden" name="jumlah" value="<?php echo $data['jumlah']; ?>" class="form-control" required="">	
					

					<input type="hidden" name="ke_akun" value="<?php echo $data['ke_akun']; ?>" class="form-control" readonly="" required="">


					<input type="hidden" name="dari_akun" value="<?php echo $data['dari_akun']; ?>" class="form-control" readonly="" required="">


					<div class="form-group">
					<label> Keterangan </label><br>
					<textarea type="text" name="keterangan" class="form-control"></textarea>
					
					</div>

					

					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<button type="submit" class="btn btn-info">Edit</button>
</div>
</form>
