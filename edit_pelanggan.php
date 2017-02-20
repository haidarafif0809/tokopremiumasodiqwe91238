<?php include 'session_login.php';

 include 'db.php';
 include 'header.php';
 include 'navbar.php';


 $id = $_GET['id'];


 $query = $db->query("SELECT * FROM pelanggan WHERE id = '$id'");
 
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>




<form action="update_pelanggan.php" method="post">
<div class="container">

<div class="form-group">
					
					<h3>Edit Data Pelanggan </h3><br><br>

					<div class="form-group">
					<label> Kode Pelanggan </label><br>
					<input type="text" name="kode_pelanggan" value="<?php echo $data['kode_pelanggan']; ?>" class="form-control" required="" >
					</div>


					<div class="form-group">
					<label> Nama Pelanggan </label><br>
					<input type="text" name="nama_pelanggan" value="<?php echo $data['nama_pelanggan']; ?>" class="form-control" required="" >
					</div>



					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<button type="submit" class="btn btn-info">Edit</button>
</div>
</form>
