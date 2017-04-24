<?php  include 'session_login.php';


// memasukkan file
 include 'header.php';
 include 'navbar.php';
 include 'db.php';

// mengirim data id dengan metode GET
 $id = $_GET['id'];
 
 // perintah untuk menampilkan data yang ada pada tabel barang berdasarkan id
 $query = $db->query("SELECT b.nama_barang, b.harga_beli, b.harga_jual, b.harga_jual2, b.harga_jual3, b.satuan, b.gudang, b.gudang, b.kategori, b.status, b.berkaitan_dgn_stok, b.suplier, b.limit_stok, b.over_stok, s.nama FROM barang b INNER JOIN satuan s ON b.satuan = s.id WHERE b.id = '$id'");
 
 // perintah untuk menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);
 ?>



<!-- membuat form dengan metode POST -->
<form enctype="multipart/form-data" action="proseseditbarang.php" method="post">
<div class="container">

				
					<!-- membuat agar tampilan form berada dalam satu group-->
					<div class="form-group">
					<label>Nama Barang </label><br>
					<input type="text" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" class="form-control" autocomplete="off"  >
					</div>

					<div class="form-group">
					<label> Harga Beli </label><br>
					<input type="text" name="harga_beli" value="<?php echo $data['harga_beli']; ?>" class="form-control" autocomplete="off"  >
					</div>

							<div class="form-group">
							<label> Harga Jual Level 1</label>
							<br>
							<input type="text" placeholder="Harga Jual Level 1" name="harga_jual" id="harga_jual" value="<?php echo $data['harga_jual'] ?>" class="form-control" autocomplete="off" >
							</div>
							<div class="form-group">
							<label> Harga Jual Level 2</label>
							<br>
							<input type="text" placeholder="Harga Jual Level 2" name="harga_jual_2" id="harga_jual2" value="<?php echo $data['harga_jual2'] ?>" class="form-control" autocomplete="off" >
							</div>
							<div class="form-group">
							<label> Harga Jual Level 3</label>
							<br>
							<input type="text" placeholder="Harga Jual Level 3" name="harga_jual_3" id="harga_jual3"  value="<?php echo $data['harga_jual3'] ?>" class="form-control" autocomplete="off" >
							</div>
					
					<div class="form-group">
					<label> Satuan </label><br>
					<select type="text" name="satuan" class="form-control"  >
					
					<option value="<?php echo $data['satuan']; ?>"><?php echo $data['nama']; ?></option>
					
					<?php 
					
					// memasukkakan file db.php
					include 'db.php';
					
					//perintah untuk menampilkan data yang ada pada tabel satuan
					$query1 = $db->query("SELECT * FROM satuan ");
					
					//menyimpan data sementara yang ada pada $query
					while($data1 = mysqli_fetch_array($query1))
					{
					
					//menampilkan data atau isi dari $data
					echo "<option value='".$data1['id']."' >".$data1['nama'] ."</option>";
					}
					
					
					?>
					
					</select>
					</div>

							
							<div style="display: none" class="form-group">
							<label> Gudang </label>
							<br>
							<select type="text" name="gudang" class="form-control" >
							<option value="<?php echo $data['gudang']; ?>"> <?php echo $data['gudang']; ?> </option>
							<?php 
							
							$ambil_gudang = $db->query("SELECT nama_gudang FROM gudang");
							
							while($data_gudang = mysqli_fetch_array($ambil_gudang))
							{
							
							echo "<option>".$data_gudang['nama_gudang'] ."</option>";
							
							}
							
							?>
							</select>
							</div>


							
							<div class="form-group">
							<label> Kategori </label>
							<br>
							<select type="text" name="kategori" class="form-control" >
							<option value="<?php echo $data['kategori']; ?>"> <?php echo $data['kategori']; ?> </option>
							<?php 
							
							$ambil_kategori = $db->query("SELECT * FROM kategori");
							
							while($data_kategori = mysqli_fetch_array($ambil_kategori))
							{
							
							echo "<option>".$data_kategori['nama_kategori'] ."</option>";
							
							}
							
							?>
							</select>
							</div>

							<!-- membuat agar tampilan form berada dalam satu group-->
							<div class="form-group">
							<label> Status </label><br>
							<select type="text" name="status" class="form-control"  >
							<option value="<?php echo $data['status']; ?>"><?php echo $data['status']; ?></option>
							<option> Aktif </option>
							<option> Tidak Aktif </option>
							</select>
							</div>
							
							
							
							<div class="form-group">
                            <label> Tipe </label>
                            <br>
                            <select type="text" name="tipe" class="form-control" >
                            <option value="<?php echo $data['berkaitan_dgn_stok']; ?>"><?php echo $data['berkaitan_dgn_stok']; ?></option>
                            <option> Barang </option>
                            <option> Jasa </option>
							</select>
							</div>
					
					<div class="form-group">
					<label> Suplier </label><br>
					<select type="text" name="suplier" class="form-control"  >
					<option value="<?php echo $data['suplier']; ?>"> <?php echo $data['suplier']; ?> </option>
					
					<?php 
					
					//memasukkan file db.php
					include 'db.php';
					
					//perintah untuk menampilakan semua data yang ada pada tabel suplier
					$query2 = $db->query("SELECT * FROM suplier ");
					
					//perintah untuk menyimpan data sementara yang ada pada $query
					while($data2 = mysqli_fetch_array($query2))
					{
					
					//menampilkan data atau isi dari $data
					echo "<option>".$data2['nama'] ."</option>";
					}
					
					//Untuk Memutuskan Koneksi Ke Database
					
					mysqli_close($db); 
					
					?>
					
					</select>
					</div> 

					<div class="form-group">
					<label> Limit Stok </label><br>
					<input type="text" name="limit_stok" value="<?php echo $data['limit_stok']; ?>" class="form-control" autocomplete="off"  >
					</div>

					<div class="form-group">
					<label> Over Stok </label><br>
					<input type="text" name="over_stok" value="<?php echo $data['over_stok']; ?>" class="form-control" autocomplete="off" >
					</div>


					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<!-- membuat tombol Edit -->
					<button type="submit" class="btn btn-info">Simpan</button>

</div><!-- tag penutup div class=container -->

</form>


<?php 

// memasukan file footer.php
include 'footer.php'; 
?>
