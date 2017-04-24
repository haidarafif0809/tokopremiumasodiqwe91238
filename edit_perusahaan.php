<?php include 'session_login.php';


// memasukkan file
 include 'header.php';
 include 'navbar.php';
 include 'db.php';

// mengirim data id dengan metode GET
 $id = $_GET['id'];
 
 // perintah untuk menampilkan data yang ada pada tabel barang berdasarkan id
 $query = $db->query("SELECT * FROM perusahaan WHERE id = '$id'");
 
 // perintah untuk menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>




<!-- membuat form dengan metode POST -->
<form enctype="multipart/form-data" action="proses_edit_perusahaan.php" method="post">
<div class="container">

				
					<!-- membuat agar tampilan form berada dalam satu group-->
					<div class="form-group">
					<label>Nama Perusahaan </label><br>
					<input type="text" name="nama_perusahaan" value="<?php echo $data['nama_perusahaan']; ?>" class="form-control" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Alamat Perusahaan </label><br>
					<input type="text" name="alamat_perusahaan" value="<?php echo $data['alamat_perusahaan']; ?>" class="form-control" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Singkatan Perusahaan </label><br>
					<input type="text" name="singkatan_perusahaan" value="<?php echo $data['singkatan_perusahaan']; ?>" class="form-control" autocomplete="off" required="" >
					</div>


					<div class="form-group">
					<label> Foto </label><br>
					<input type="file" name="foto" required="" >
					</div>

					<div class="form-group">
					<label> Nomor Telepon </label><br>
					<input type="text" name="no_telp" class="form-control" value="<?php echo $data['no_telp']; ?>" class="form-control" autocomplete="off" required=""  >
					</div>

					<div class="form-group">
					<label> Nomor Fax </label><br>
					<input type="text" name="no_fax" class="form-control" value="<?php echo $data['no_fax']; ?>" class="form-control" autocomplete="off" required=""  >
					</div>

							

					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<!-- membuat tombol Edit -->
					<button type="submit" class="btn btn-info">Edit</button>

</div><!-- tag penutup div class=container -->

</form>


<?php 

// memasukan file footer.php
include 'footer.php'; 
?>
