<?php include 'session_login.php';


// memasukan file session login, db,header dan navbar.php
 include 'db.php';
 include 'header.php';
 include 'navbar.php';

// mengirim data $id menggunakan metode GET
 $id = $_GET['id'];
 
 // menampilkan seluruh data dari tabel user berdasarkan id
 $query = $db->query("SELECT ho.nama AS otoritas_user,j.nama AS nama_jabatan ,u.id,u.username,u.nama,u.alamat,u.password,u.jabatan,u.otoritas,u.status,u.status_sales
FROM user u LEFT JOIN jabatan j ON u.jabatan = j.id LEFT JOIN hak_otoritas ho ON u.otoritas=  ho.id  WHERE  u.id = '$id'");
 
 // menyimpan data sementara yang ada pada $query
 $data = mysqli_fetch_array($query);
 ?>



<!-- membuat form prosesedit -->
<form action="prosesedit.php" method="post">

<!-- agar tampilan form terlihat rapih dalam satu tempat -->
<div class="container">

					<!--membuat form group-->
					<div class="form-group">
					<label>User name </label><br>
					<input type="text" name="username" value="<?php echo $data['username']; ?>" class="form-control" required="" >
					</div>


					<div class="form-group">
					<label>Nama Lengkap </label><br>
					<input type="text" name="nama" value="<?php echo $data['nama']; ?>" class="form-control" required="" >
					</div>

					<div class="form-group">
					<label>Alamat </label><br>

					<input value="<?php echo $data['alamat']; ?>" name="alamat" class="form-control" required=""></input>

					</div>


					<div class="form-group">
					<label>Jabatan </label><br>
					<select type="text" name="jabatan" class="form-control" required="" >
					<option value="<?php echo $data['jabatan']; ?>"><?php echo $data['nama_jabatan']; ?></option>

					<?php 

						// memasukan file db.php
					    include 'db.php';
					    
					    // menampilkan seluruh data yang ada di tabel satuan
					    $query = $db->query("SELECT id, nama FROM jabatan ");

					    // menyimpan data sementara yang ada pada $query
					    while($data002 = mysqli_fetch_array($query))
					    {
					    
					    echo "<option value=".$data002['id'].">".$data002['nama'] ."</option>";
					    }
					    
					    
					    ?>

    				</select>
					</div>
					

					<div class="form-group">
					<label>Otoritas</label><br>
					<select type="text" name="otoritas" id="otoritas" class="form-control" required="" >
					<option value="<?php echo $data['otoritas']; ?>"><?php echo $data['otoritas_user']; ?></option>
						<?php 

						$ambil_otoritas = $db->query("SELECT id, nama FROM hak_otoritas");

						    while($data_otoritas = mysqli_fetch_array($ambil_otoritas))
						    {
						    
						    echo "<option value=".$data_otoritas['id'].">".$data_otoritas['nama'] ."</option>";

						    }
						    
						//Untuk Memutuskan Koneksi Ke Database

						mysqli_close($db); 
						 ?>
					</select>
					</div>

					<div class="form-group">
					<label> Status </label><br>
					<select type="text" name="status" class="form-control" required="" >
					<option>aktif</option>
					<option>tidak aktif</option>
					</select>
					</div>

					<div class="form-group">
					<label> Status Sales</label><br>
					<select type="text" name="status_sales" id="status_sales" class="form-control" required="" >
					<option value="<?php echo $data['status_sales']; ?>"><?php echo $data['status_sales']; ?></option>
					<option value="Iya">Iya</option>
					<option value="Tidak">Tidak</option>
					</select>
					</div>


					<!-- memasukan data id namun disembunyikan -->
					<input type="hidden" name="id" value="<?php echo $id; ?>">

					<!-- membuat tombol submit -->
					<button type="submit" class="btn btn-info">Edit</button>
</div> <!-- tag penutup div class container -->
</form> <!-- tag penutup form -->
