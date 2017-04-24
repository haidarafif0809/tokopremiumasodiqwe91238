<?php 	include 'session_login.php';


	// memasukan file db.php dan header.php
	include 'db.php';
	include 'header.php';
	include 'navbar.php';

 
// mengirim data $id dengan menggunakan metode GET
 $id = $_GET['id'];
 
 // perintah menampilkan seluruh data yang ada di tabel jabatan berdasarkan id 
 $query = $db->query("SELECT * FROM jabatan WHERE id = '$id'");
 
 // menyimpan data smentara yang ada pada $query
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>



<!-- membuat form update jabatan -->
<form action="update_jabatan.php" method="post">
<div class="container">


				

					<div class="form-group">
					<label> Nama Jabatan </label><br>
					<input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" required="" >
					</div>

					

					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<button type="submit" class="btn btn-info">Edit</button>
</div> <!-- tag penutup div class=container -->
</form> <!-- tag penutup form -->
