<?php include 'session_login.php';

 include 'db.php';
 include 'header.php';
 include 'navbar.php';


 $id = $_GET['id'];
 
 $query = $db->query("SELECT * FROM pemasukan WHERE id = '$id'");
 
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>




<form action="update_pemasukan.php" method="post">
<div class="container">

<div class="form-group">
					

					<div class="form-group">
					<label> Nama </label><br>
					<input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" required="" >
					</div>

					

					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<button type="submit" class="btn btn-info">Edit</button>
</div>
</form>
