<?php include 'session_login.php';


// memasukkan file session login, db, header, navbar
 include 'db.php';
 include 'header.php';
 include 'navbar.php';
 
// mengirimkan data $id dengan metode GET
 $id = $_GET['id'];

 // mengirim data $harga dengan metode GET

 

 
 // perintah untuk menampilkan semua data pada tabel tbs_pembelian berdasarkan id
 $query = $db->query("SELECT * FROM detail_pembelian WHERE id = '$id'");
 
 // menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>



<!-- membuat form update tbs pembelian -->
<form action="update_coba.php" method="post">
<div class="container"> <!-- membuat tampilan form agar terlihat rapih dalam satu tempat -->

				


					<div class="form-group">
					<label> Jumlah Barang Baru </label><br>
					<input type="text" name="jumlah_baru" class="form-control" required="" autocomplete="off">
					</div>
					<!-- membuat form group-->
					<div class="form-group">
					<label> Jumlah Barang </label><br>
					<input type="text" name="jumlah_barang" value="<?php echo $data['jumlah_barang']; ?>" class="form-control" readonly="" required="" >
					</div>

					<!--memasukkan data harga namun disembunyikan-->
					<input type="hidden" name="harga" value="<?php echo $data['harga']; ?>">

					<!--memasukkan data id namun disembunyikan-->
					<input type="hidden" name="id" value="<?php echo $id; ?>">

					<input type="hidden" name="kode_barang" value="<?php echo $data['kode_barang']; ?>">
					<!-- membuat tombol submit-->
					<button type="submit" class="btn btn-info">Edit</button>


</div> <!--tag penutup class=container-->
</form> <!-- tag penutup form-->

<?php 
//memasukkan file footer
include 'footer.php';
 ?>