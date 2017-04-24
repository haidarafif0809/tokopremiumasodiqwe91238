<?php include 'session_login.php';


// memasukkan file
 include 'header.php';
 include 'navbar.php';
 include 'db.php';

// mengirim data id dengan metode GET
 $id = $_GET['id'];
 
 // perintah untuk menampilkan data yang ada pada tabel barang berdasarkan id
 $query = $db->query("SELECT * FROM barang WHERE id = '$id'");
 
 // perintah untuk menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);

 	//Untuk Memutuskan Koneksi Ke Database
mysqli_close($db);   
 ?>




<!-- membuat form dengan metode POST -->
<form enctype="multipart/form-data" action="proses_unggah_foto.php" method="post">
<div class="container">

					<div class="form-group">
					<label> Foto </label><br>
					<input type="file" name="foto" required="" >
					</div>
							

					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<!-- membuat tombol Edit -->
					<button type="submit" class="btn btn-info">Unggah</button>

</div><!-- tag penutup div class=container -->

</form>


<?php 

// memasukan file footer.php
include 'footer.php'; 
?>
