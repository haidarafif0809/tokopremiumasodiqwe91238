<?php include 'session_login.php';

// memasukkan file session_login.php, db.php, header.php, navbar.php
 include 'db.php';
 include 'header.php';
 include 'navbar.php';
 
//mengirimkan data $id menggunakan metode GET
 $id = $_GET['id'];
 
 // menampilkan seluruh data yang ada pada tabel suplier berdasarkan id
 $query = $db->query("SELECT * FROM suplier WHERE id = '$id'");
 
 // menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>



<!-- membuat form updatesuplier -->
<form action="updatesuplier.php" method="post">
<div class="container"> <!--membuat tampilan form agar terlihat rapih dalam satu tempat -->

				
					<!-- membuat form -->
					<div class="form-group">
					<label> Nama Suplier </label><br>
					<input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" required="" >
					</div>

					<div class="form-group">
					<label> Alamat </label><br>
					<input type="text" name="alamat" value="<?php echo $data['alamat']; ?>" class="form-control" required="" >
					</div>

					<div class="form-group">
					<label> Nomor Telpon </label><br>
					<input type="text" name="no_telp" value="<?php echo $data['no_telp']; ?>" class="form-control" required="" >
					</div>
					

					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<button type="submit" class="btn btn-info">Edit</button>
</div> <!-- tag penutup class=container -->
</form> <!-- tag penutup form -->
