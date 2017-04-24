<?php include 'session_login.php';


// memasukan file session login,  header, navbar, db.php,
include 'header.php';
include 'navbar.php';
include 'db.php';
include 'sanitasi.php';
include 'bootstrap.php';


 $query = $db->query("SELECT * FROM meja");

 ?>





<h3><center> Daftar Meja </center></h3><br>



<?php 

while ($data=mysqli_fetch_array($query)) 
	{

		if ($data['status_pakai'] == 'Belum Terpakai') {
			
			echo '<a href="pesan_meja.php?kode_meja='.$data['kode_meja'].'"> <div class="img" style="background-color:lightgrey" data-kode="'. $data['kode_meja'] .'" nama-meja="'. $data['nama_meja'] .'">			
			
			<div class="desc">'.$data['kode_meja'].'--'.$data['nama_meja'].'</div>
			</div></a>';
		}
		elseif ($data['status_pakai'] == 'Sudah Terpakai') {
			
			echo '<a href="pesan_meja.php?kode_meja='.$data['kode_meja'].'"> <div style="background-color:#ff4d4d" class="img" data-kode="'. $data['kode_meja'] .'" nama-meja="'. $data['nama_meja'] .'">			
			
			<div class="desc">'.$data['kode_meja'].'--'.$data['nama_meja'].'</div>
			</div></a>';
		}
			

			
	} 

//Untuk Memutuskan Koneksi Ke Database

mysqli_close($db); 

 ?>                                                                                                        



 <div class="col-sm-6">
 	


 </div>
							
				<!-- memasukan file footer.php -->
				<?php
				
				include 'footer.php'; 
				
				?>