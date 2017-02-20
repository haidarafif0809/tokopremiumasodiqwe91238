<?php include 'session_login.php';


//memasukkan file sesion login, db, header, navbar
 include 'db.php';
 include 'header.php';
 include 'navbar.php';
 
// mengirim data $id menggunakan metode GET
 $id = $_GET['id'];

 
 
 // perintah untuk menampilkan seluruh data pada tabel tbs penjualan berdasarkan id
 $query = $db->query("SELECT * FROM tbs_retur_pembelian WHERE id = '$id'");
 
 // menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);

 //Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 
 ?>



<!--membuat form update tbs penjualan-->
<form action="update_tbs_retur_pembelian.php" method="post">
<div class="container"> <!-- membuat agar tampilan form terlihat rapih dalam satu tempat -->

					

					<div class="form-group">
					<label> Jumlah Retur Baru </label><br>
					<input type="text" name="jumlah_baru" class="form-control" required="" >
					</div>
					<!--membuat form group-->
					<div class="form-group">
					<label> Jumlah Retur </label><br>
					<input type="text" name="jumlah_retur" value="<?php echo $data['jumlah_retur']; ?>" class="form-control" readonly="" required="" >
					</div>

					<input type="hidden" name="harga" value="<?php echo $data['harga']; ?>">
					<!--memasukkan data id namun disembunyikan-->
					<input type="hidden" name="id" value="<?php echo $id; ?>">

					<input type="hidden" name="kode_barang" value="<?php echo $data['kode_barang']; ?>">

					<!--membuat tombol submit-->
					<button type="submit" class="btn btn-info">Edit</button>
</div><!--tag penutup class=container-->
</form><!--tag penutup form-->
