<?php include 'session_login.php';


 // memasukan file session login, db, header dan navbar.php
 include 'db.php';
 include 'header.php';
 include 'navbar.php';

// mengirim data $id menggunakan metode GET
 $id = $_GET['id'];
 
 // menampilkan seluruh data yang ada ditabel sauan berdasarkan id
 $query = $db->query("SELECT * FROM satuan WHERE id = '$id'");
 
 // menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>



<!-- membuat form updatesatuan -->
<form action="updatesatuan.php" method="post">
<div class="container"> <!-- membuat agar form terlihat rapi dan ditempatkan pada satu tempat -->


					

					<div class="form-group">
					<label> Nama </label><br>
					<input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" required="" >
					</div>

					

					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<button type="submit" class="btn btn-info">Edit</button>
</div> <!-- tag penutup div class container -->
</form><!-- tag penutup form  -->
