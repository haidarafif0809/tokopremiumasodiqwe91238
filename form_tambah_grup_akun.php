<?php include 'session_login.php';

    
    //memasukkan file session login, header, navbar, db
    include 'header.php';
    include 'navbar.php';
    include 'db.php';
    include 'sanitasi.php';
    
?>

<div class="container">

<h3><b><u> GROUP AKUN</u></b></h3> <br>

<form action="proses_daftar_grup_akun.php" method="post">
					<div class="form-group">
					<label> Kode Group Akun </label><br>
					<input type="text" name="kode_akun" id="kode_akun" class="form-control" placeholder="Kode Group Akun" autocomplete="off" required="" >
					</div>

					<div class="form-group">
					<label> Nama Group Akun </label>
					<br>
					<input type="text" id="nama_akun" name="nama_akun" class="form-control" placeholder="Nama Group Akun" autocomplete="off" required="">

					</div>


					<div class="form-group">
					<label> Sub Dari </label><br>
					<select type="text" name="sub_dari" id="sub_dari" class="form-control chosen">
					<option value="-"> - </option>

						<?php 
						$select = $db->query("SELECT kode_grup_akun, nama_grup_akun FROM grup_akun ");
						while ($ambil = mysqli_fetch_array($select))
						{

						echo"<option value='".$ambil['kode_grup_akun']."'>".$ambil['kode_grup_akun']." -- ".$ambil['nama_grup_akun']."</option>";
						}


						//Untuk Memutuskan Koneksi Ke Database
						mysqli_close($db);   
						 ?>
					
					</select>
					</div>

					<div class="form-group">
					<label> Kategori Akun </label><br>
					<select type="text" name="kategori_akun" id="kategori_akun" class="form-control chosen">

					<option value="">--Kategori Akun--</option>	

					<option>Aktiva</option>	
					<option>Kewajiban</option>	
					<option>Modal</option>	
					<option>Pendapatan</option>	
					<option>HPP</option>	
					<option>Biaya</option>
					<option>Pendapatan Lain</option>	
					<option>Biaya Lain</option>	

					</select>
					</div>

					<div class="form-group">
					<label> Tipe Akun </label><br>
					<input type="text" name="tipe_akun" id="tipe_akun" class="form-control" value="Akun Header" autocomplete="off" required="" readonly="">
					
					</div>

   
   					<button type="submit" id="submit_tambah" class="btn btn-primary"><span class='glyphicon glyphicon-plus'> </span> Tambah</button>

</form>
</div> <!-- end container-->





      <script type="text/javascript">
      
      $(".chosen").chosen({no_results_text: "Maaf, Data Tidak Ada!",search_contains:true});     
      
      </script>

<script type="text/javascript">

               $(document).ready(function(){
               $("#kode_akun").blur(function(){
               var kode_akun = $("#kode_akun").val();

              $.post('cek_kode_akun.php',{kode_akun:$(this).val()}, function(data){
                
                if(data == 1){

                    alert ("Kode Akun Sudah Ada");
                    $("#kode_akun").val('');
                    $("#kode_akun").focus();
                }
                else {
                    
                }
              });
                
               });
               });

</script>

<?php 

// memasukan file footer.php
include 'footer.php'; 
?>